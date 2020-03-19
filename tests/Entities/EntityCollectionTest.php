<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Entities;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Doctrine\Enumerations\Constructors\TypedEnumerableConstructor;
use Somnambulist\Domain\Doctrine\TypeBootstrapper;
use Somnambulist\Domain\Doctrine\Types\EnumerationBridge;
use Somnambulist\Domain\Entities\AbstractEntityCollection;
use Somnambulist\Domain\Entities\Types\Auth\Password;
use Somnambulist\Domain\Entities\Types\Identity\EmailAddress;
use Somnambulist\Domain\Tests\Support\Stubs\Events\UserJoinedGroup;
use Somnambulist\Domain\Tests\Support\Stubs\Models\Group;
use Somnambulist\Domain\Tests\Support\Stubs\Models\Name;
use Somnambulist\Domain\Tests\Support\Stubs\Models\Role;
use Somnambulist\Domain\Tests\Support\Stubs\Models\User;
use Somnambulist\Domain\Tests\Support\Stubs\Models\UserGroup;
use Somnambulist\Domain\Tests\Support\Stubs\Models\UserId;
use Somnambulist\Domain\Tests\Support\Stubs\Types\UserIdType;
use Somnambulist\Domain\Utils\IdentityGenerator;
use Somnambulist\Domain\Utils\Tests\Assertions\AssertHasDomainEventOfType;
use function password_hash;
use function realpath;
use function strpos;
use function sys_get_temp_dir;
use const PASSWORD_DEFAULT;

/**
 * Class EntityCollectionTest
 *
 * @package    Somnambulist\Domain\Tests\Entities
 * @subpackage Somnambulist\Domain\Tests\Entities\EntityCollectionTest
 *
 * @group entities
 * @group entities-collection
 */
class EntityCollectionTest extends TestCase
{

    use AssertHasDomainEventOfType;

    public function testBasicCollectionMethods()
    {
        $user = $this->makeUser();

        $col = $user->groups();

        $this->assertInstanceOf(AbstractEntityCollection::class, $col);
        $this->assertCount(0, $col);
    }

    public function testAddingElements()
    {
        $user = $this->makeUser();

        $user->groups()->join(new Group('0accbf52-d55e-4505-a709-1ef483811731'), Role::LEADER());

        $this->assertInstanceOf(UserGroup::class, $user->groups()->get(1));
        $this->assertEquals(1, $user->groups()->get(1)->id());

        $this->assertHasDomainEventOfType($user, UserJoinedGroup::class);
    }

    public function testPersistingDDDStyleNestedEntities()
    {
        $user = $this->makeUser();
        $id   = $user->id();

        $user->groups()->join(new Group('0accbf52-d55e-4505-a709-1ef483811731'), Role::LEADER());

        $em = $this->makeEntityManager();

        $em->persist($user);
        $em->flush();
        $em->clear();

        $loadedUser = $em->getRepository(User::class)->find($id);

        $this->assertTrue($id->equals($loadedUser->id()));
        $this->assertCount(1, $loadedUser->groups());
        $this->assertEquals(1, $loadedUser->groups()->get(1)->id());
    }

    public function testPersistingMultipleDDDStyleNestedEntities()
    {
        $user = $this->makeUser();
        $id   = $user->id();

        $user->groups()->join($g1 = new Group('0accbf52-d55e-4505-a709-1ef483811731'), Role::LEADER());
        $user->groups()->join($g2 = new Group('b7c1a7ad-956b-45de-85be-fe507b190102'), Role::MEMBER());
        $user->groups()->join($g3 = new Group('7829b3e1-bc4a-406d-8a34-895cbfecd1ae'), Role::MEMBER());

        $em = $this->makeEntityManager();

        $em->persist($user);
        $em->flush();
        $em->clear();

        /** @var User $loadedUser */
        $loadedUser = $em->getRepository(User::class)->find($id);

        $this->assertTrue($id->equals($loadedUser->id()));
        $this->assertCount(3, $loadedUser->groups());
        $this->assertEquals(3, $loadedUser->groups()->get(3)->id());

        $loadedUser->groups()->leave($g2);
        $em->flush();

        $loadedUser->groups()->join($g2 = new Group('b7c1a7ad-956b-45de-85be-fe507b190102'), Role::MEMBER());
        $em->flush();

        $this->assertEquals(3, $em->getConnection()->executeQuery('SELECT COUNT(*) FROM user_groups WHERE user_id = :id', ['id' => $id])->fetchColumn());

        $this->assertEquals(4, $loadedUser->groups()->for($g2)->id());
    }

    private function makeUser(): User
    {
        $user = User::create(
            $id = IdentityGenerator::randomOfType(UserId::class),
            new Name('bob'),
            new EmailAddress('bob@example.com'),
            new Password(password_hash('password', PASSWORD_DEFAULT))
        );

        return $user;
    }

    protected function makeEntityManager(): EntityManager
    {
        $conn = [
            'driver'   => $GLOBALS['DOCTRINE_DRIVER'],
            'memory'   => $GLOBALS['DOCTRINE_MEMORY'],
            'dbname'   => $GLOBALS['DOCTRINE_DATABASE'],
            //'path' => __DIR__ . '/../../var/sqlite.db',
            'user'     => $GLOBALS['DOCTRINE_USER'],
            'password' => $GLOBALS['DOCTRINE_PASSWORD'],
            'host'     => $GLOBALS['DOCTRINE_HOST'],
        ];

        $driver = new SimplifiedXmlDriver([
            realpath(__DIR__ . '/../Support/Stubs/config/ddd') => 'Somnambulist\Domain\Tests\Support\Stubs\Models',
            realpath(__DIR__ . '/../../config/xml/symfony') => 'Somnambulist\Domain\Entities\Types',
        ]);
        $config = new Configuration();
        $config->setMetadataCacheImpl(new ArrayCache());
        $config->setQueryCacheImpl(new ArrayCache());
        $config->setProxyDir(sys_get_temp_dir());
        $config->setProxyNamespace('Somnambulist\Tests\DomainEvents\Proxies');
        $config->setMetadataDriverImpl($driver);
        //$config->setSQLLogger(new EchoSQLLogger());

        TypeBootstrapper::registerEnumerations();
        TypeBootstrapper::registerTypes(TypeBootstrapper::$types);
        TypeBootstrapper::registerTypes([
            'user_id' => UserIdType::class,
        ]);
        EnumerationBridge::registerEnumType('group_role', new TypedEnumerableConstructor(Role::class));

        $em = EntityManager::create($conn, $config);

        $schemaTool = new SchemaTool($em);

        try {
            $schemaTool->createSchema([
                $em->getClassMetadata(User::class),
                $em->getClassMetadata(UserGroup::class),
            ]);
        } catch (\Exception $e) {
            if (
                $GLOBALS['DOCTRINE_DRIVER'] != 'pdo_mysql' ||
                !($e instanceof \PDOException && strpos($e->getMessage(), 'Base table or view already exists') !== false)
            ) {
                throw $e;
            }
        }

        return $em;
    }
}
