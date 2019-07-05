<?php

namespace Somnambulist\Domain\Tests\Doctrine;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;
use Somnambulist\Collection\Collection;
use Somnambulist\Domain\Doctrine\Bootstrapper;
use Somnambulist\Domain\Entities\Types\DateTime\DateTime;
use Somnambulist\Domain\Entities\Types\DateTime\TimeZone;
use Somnambulist\Domain\Entities\Types\Geography\Country;
use Somnambulist\Domain\Entities\Types\Identity\EmailAddress;
use Somnambulist\Domain\Entities\Types\Identity\Uuid;
use Somnambulist\Domain\Entities\Types\Money\Currency;
use Somnambulist\Domain\Entities\Types\Money\Money;
use Somnambulist\Domain\Tests\Doctrine\Entities\Order;
use Somnambulist\Domain\Tests\Doctrine\Entities\ValueObjects\Purchaser;

/**
 * Class XmlMappingTest
 *
 * @package    Somnambulist\Tests\Doctrine
 * @subpackage Somnambulist\Tests\Doctrine\XmlMappingTest
 * @group xml-mappings
 */
class XmlMappingTest extends TestCase
{

    /**
     * @var EntityManager
     */
    protected $em;

    protected function setUp()
    {
        $conn = [
            'driver'   => $GLOBALS['DOCTRINE_DRIVER'],
            'memory'   => $GLOBALS['DOCTRINE_MEMORY'],
            'dbname'   => $GLOBALS['DOCTRINE_DATABASE'],
            'user'     => $GLOBALS['DOCTRINE_USER'],
            'password' => $GLOBALS['DOCTRINE_PASSWORD'],
            'host'     => $GLOBALS['DOCTRINE_HOST'],
        ];

        $driver = new XmlDriver([
            __DIR__ . '/_data/mappings',
            __DIR__ . '/../../config/xml/doctrine',
        ]);
        $config = new Configuration();
        $config->setMetadataCacheImpl(new ArrayCache());
        $config->setQueryCacheImpl(new ArrayCache());
        $config->setProxyDir(sys_get_temp_dir());
        $config->setProxyNamespace('Somnambulist\Domain\Tests\Doctrine\Proxies');
        $config->setMetadataDriverImpl($driver);

        Bootstrapper::registerEnumerations();
        Bootstrapper::registerTypes();

        $em = EntityManager::create($conn, $config);

        $schemaTool = new SchemaTool($em);

        try {
            $schemaTool->createSchema([
                $em->getClassMetadata(Order::class),
            ]);
        } catch (\Exception $e) {
            if (
                $GLOBALS['DOCTRINE_DRIVER'] != 'pdo_mysql' ||
                !($e instanceof \PDOException && strpos($e->getMessage(), 'Base table or view already exists') !== false)
            ) {
                throw $e;
            }
        }

        $this->em = $em;
    }

    protected function tearDown()
    {
        $this->em = null;
    }



    /**
     * @group doctrine
     */
    public function testCanPersistAndRestoreValueObjectsAndEnumerations()
    {
        $entity = new Order(
            $uuid = new Uuid(\Ramsey\Uuid\Uuid::uuid4()),
            new Purchaser('Foo Bar', new EmailAddress('foo.bar@example.com'), Country::memberByKey('CAN')),
            new Money(34.56, Currency::memberByKey('CAD')),
            DateTime::parse('now', new TimeZone('America/Toronto'))
        );
        $entity->properties()->set('items', [
            ['name' => 'test one',],
            ['name' => 'test two',],
            ['name' => 'test three',],
        ])
        ;

        $this->em->persist($entity);
        $this->em->flush();

        $entity = null;
        unset($entity);

        /** @var Order $loaded */
        $loaded = $this->em->getRepository(Order::class)->findAll()[0];

        $this->assertInstanceOf(Order::class, $loaded);
        $this->assertInstanceOf(Collection::class, $loaded->properties());
        $this->assertInstanceOf(Purchaser::class, $loaded->purchaser());
        $this->assertInstanceOf(Money::class, $loaded->total());
        $this->assertInstanceOf(DateTime::class, $loaded->createdAt());

        $this->assertCount(1, $loaded->properties());
        $this->assertArrayHasKey('items', $loaded->properties());

        $this->assertTrue($uuid->equals($loaded->orderRef()));
        $this->assertEquals('Foo Bar', $loaded->purchaser()->name());
        $this->assertEquals('foo.bar@example.com', (string)$loaded->purchaser()->email());
        $this->assertTrue(Country::memberByKey('CAN')->equals($loaded->purchaser()->country()));

        $this->assertEquals(34.56, $loaded->total()->amount());
        $this->assertEquals('CAD', $loaded->total()->currency()->code());
    }
}
