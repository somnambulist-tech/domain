<?php

namespace Somnambulist\Domain\Tests\Doctrine;

use PHPUnit\Framework\TestCase;
use Somnambulist\Collection\MutableCollection as Collection;
use Somnambulist\Domain\Doctrine\TypeBootstrapper;
use Somnambulist\Domain\Entities\Types\DateTime\DateTime;
use Somnambulist\Domain\Entities\Types\DateTime\TimeZone;
use Somnambulist\Domain\Entities\Types\Geography\Country;
use Somnambulist\Domain\Entities\Types\Identity\EmailAddress;
use Somnambulist\Domain\Entities\Types\Identity\Uuid;
use Somnambulist\Domain\Entities\Types\Money\Currency;
use Somnambulist\Domain\Entities\Types\Money\Money;
use Somnambulist\Domain\Tests\Support\Behaviours\BuildDoctrineInstance;
use Somnambulist\Domain\Tests\Support\Stubs\Models\Order;
use Somnambulist\Domain\Tests\Support\Stubs\Models\ValueObjects\Purchaser;

/**
 * Class XmlMappingTest
 *
 * @package    Somnambulist\Domain\Tests\Doctrine
 * @subpackage Somnambulist\Domain\Tests\Doctrine\XmlMappingTest
 *
 * @group doctrine
 * @group doctrine-mapping-xml
 */
class XmlMappingTest extends TestCase
{

    use BuildDoctrineInstance;

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
        ]);

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
