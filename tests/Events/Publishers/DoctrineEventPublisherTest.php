<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Events\Publishers;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\EventManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Doctrine\ORM\Tools\SchemaTool;
use Exception;
use PDOException;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Domain\Doctrine\TypeBootstrapper;
use Somnambulist\Components\Domain\Entities\Types\DateTime\DateTime;
use Somnambulist\Components\Domain\Entities\Types\Identity\Uuid;
use Somnambulist\Components\Domain\Events\Publishers\DoctrineEventPublisher;
use Somnambulist\Components\Domain\Tests\Support\Stubs\EventListeners\DomainEventListener;
use Somnambulist\Components\Domain\Tests\Support\Stubs\Models\MyEntity;
use Somnambulist\Components\Domain\Tests\Support\Stubs\Models\MyOtherEntity;
use function realpath;

/**
 * Class DoctrineEventPublisherTest
 *
 * @package    Somnambulist\Components\Domain\Tests\Events\Publishers
 * @subpackage Somnambulist\Components\Domain\Tests\Events\Publishers\DoctrineEventPublisherTest
 *
 * @group events
 * @group events-publishers
 * @group events-publishers-doctrine
 */
class DoctrineEventPublisherTest extends TestCase
{

    /**
     * @var EntityManager
     */
    protected $em;

    protected function setUp(): void
    {
        $evm = new EventManager();
        $evm->addEventSubscriber(new DoctrineEventPublisher(new DomainEventListener()));

        $conn = [
            'driver'   => $GLOBALS['DOCTRINE_DRIVER'],
            'memory'   => $GLOBALS['DOCTRINE_MEMORY'],
            'dbname'   => $GLOBALS['DOCTRINE_DATABASE'],
            'user'     => $GLOBALS['DOCTRINE_USER'],
            'password' => $GLOBALS['DOCTRINE_PASSWORD'],
            'host'     => $GLOBALS['DOCTRINE_HOST'],
        ];

        $driver = new SimplifiedXmlDriver([
            realpath(__DIR__ . '/../../Support/Stubs/config/sf') => 'Somnambulist\Components\Domain\Tests\Support\Stubs\Models',
        ]);
        $config = new Configuration();
        $config->setMetadataCacheImpl(new ArrayCache());
        $config->setQueryCacheImpl(new ArrayCache());
        $config->setProxyDir(sys_get_temp_dir());
        $config->setProxyNamespace('Somnambulist\Tests\DomainEvents\Proxies');
        $config->setMetadataDriverImpl($driver);

        TypeBootstrapper::registerEnumerations();
        TypeBootstrapper::registerTypes(TypeBootstrapper::$types);

        $em = EntityManager::create($conn, $config, $evm);

        $schemaTool = new SchemaTool($em);

        try {
            $schemaTool->createSchema([
                $em->getClassMetadata(MyEntity::class),
                $em->getClassMetadata(MyOtherEntity::class),
            ]);
        } catch (Exception $e) {
            if (
                $GLOBALS['DOCTRINE_DRIVER'] != 'pdo_mysql' ||
                !($e instanceof PDOException && str_contains($e->getMessage(), 'Base table or view already exists'))
            ) {
                throw $e;
            }
        }

        $this->em = $em;
    }

    protected function tearDown(): void
    {
        $this->em = null;
    }

    public function testFiresEvents()
    {
        $entity = new MyEntity(new Uuid('e9177266-5a64-420d-afda-04feb7edf14d'), 'test', 'bob');
        $this->em->persist($entity);
        $this->expectOutputString("New item created with id: e9177266-5a64-420d-afda-04feb7edf14d, name: test, another: bob\n");
        $this->em->flush();

        $this->assertCount(0, $entity->releaseAndResetEvents());
    }

    public function testFiresEventsWhenRelatedEntitiesChangedButRootNot()
    {
        $entity = new MyEntity(new Uuid('e9177266-5a64-420d-afda-04feb7edf14d'), 'test', 'bob');
        $this->em->persist($entity);
        $this->em->flush();

        $this->assertCount(0, $entity->releaseAndResetEvents());

        $this->getActualOutput();

        sleep(1);

        $entity->addRelated('example', 'test-test', DateTime::now());

        $this->em->flush();

        $expected  = "New item created with id: e9177266-5a64-420d-afda-04feb7edf14d, name: test, another: bob\n";
        $expected .= "Added related entity with name: example, another: test-test to entity id: e9177266-5a64-420d-afda-04feb7edf14d\n";

        $this->expectOutputString($expected);

        $this->assertCount(0, $entity->releaseAndResetEvents());
    }

    public function testFiresEventsInOrder()
    {
        $entity = new MyEntity(new Uuid('e9177266-5a64-420d-afda-04feb7edf14d'), 'test', 'bob');

        $entity->addRelated('example1', 'test-test1', DateTime::now());
        $entity->addRelated('example2', 'test-test2', DateTime::now());
        $entity->addRelated('example3', 'test-test3', DateTime::now());

        $this->em->persist($entity);
        $this->em->flush();

        $expected  = "New item created with id: e9177266-5a64-420d-afda-04feb7edf14d, name: test, another: bob\n";
        $expected .= "Added related entity with name: example1, another: test-test1 to entity id: e9177266-5a64-420d-afda-04feb7edf14d\n";
        $expected .= "Added related entity with name: example2, another: test-test2 to entity id: e9177266-5a64-420d-afda-04feb7edf14d\n";
        $expected .= "Added related entity with name: example3, another: test-test3 to entity id: e9177266-5a64-420d-afda-04feb7edf14d\n";

        $this->expectOutputString($expected);

        $this->assertCount(0, $entity->releaseAndResetEvents());
    }
}
