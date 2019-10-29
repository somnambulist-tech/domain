<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Utils;

use MyEntity;
use MyEntityCreatedEvent;
use MyEntityNameUpdatedEvent;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Entities\Types\DateTime\DateTime;
use Somnambulist\Domain\Tests\Events\_data\Entities\AbstractEntity;
use Somnambulist\Domain\Tests\Events\_data\Entities\MyInheritedEntity;
use Somnambulist\Domain\Utils\Tests\Assertions\AssertDoesNotHaveDomainEventOfType;
use Somnambulist\Domain\Utils\Tests\Assertions\AssertDomainEventHasAttributes;
use Somnambulist\Domain\Utils\Tests\Assertions\AssertEntityHasPropertyWithValue;
use Somnambulist\Domain\Utils\Tests\Assertions\AssertHasDomainEventOfType;

/**
 * Class AssertionHelpersTest
 *
 * @package Somnambulist\Domain\Tests\Utils
 * @subpackage Somnambulist\Domain\Tests\Utils\AssertionHelpersTest
 */
class AssertionHelpersTest extends TestCase
{

    use AssertDoesNotHaveDomainEventOfType;
    use AssertDomainEventHasAttributes;
    use AssertHasDomainEventOfType;
    use AssertEntityHasPropertyWithValue;

    public function testHasDomainEvent()
    {
        $entity = new MyEntity('id', 'test', 'test 2', DateTime::now());

        $this->assertHasDomainEventOfType($entity, MyEntityCreatedEvent::class);
    }

    public function testHasDomainEventWithCount()
    {
        $entity = new MyEntity('id', 'test', 'test 2', DateTime::now());

        $this->assertHasDomainEventOfType($entity, MyEntityCreatedEvent::class, 1);
    }

    public function testDoesNotHaveDomainEvent()
    {
        $entity = new MyEntity('id', 'test', 'test 2', DateTime::now());

        $this->assertDoesNotHaveDomainEventOfType($entity, MyEntityNameUpdatedEvent::class);
    }

    public function testEventHasAttributes()
    {
        $entity = new MyEntity('id', 'test', 'test 2', DateTime::now());

        $this->assertDomainEventHasAttributes($entity, MyEntityCreatedEvent::class, [
            'id' => 'id',
            'name' => 'test',
            'another' => 'test 2',
        ]);
    }

    public function testEntityHasPropertyValue()
    {
        $entity = new MyEntity('id', 'test', 'test 2', DateTime::now());

        $this->assertEntityHasPropertyWithValue($entity, 'id', 'id');
    }

    public function testEntityHasPropertyValueWorksWithObjects()
    {
        $entity = new MyEntity('id', 'test', 'test 2', $dt = DateTime::now());

        $this->assertEntityHasPropertyWithValue($entity, 'createdAt', $dt);
    }

    public function testEntityHasPropertyValueWorksWithInheritedPrivateProperties()
    {
        $entity = new MyInheritedEntity('id', 'test');

        $this->assertEntityHasPropertyWithValue($entity, 'name', 'test', AbstractEntity::class);
    }

    public function testEntityHasPropertyValueWorksWillFailWithWrongScope()
    {
        $entity = new MyInheritedEntity('id', 'test');

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Object of type "Somnambulist\Domain\Tests\Events\_data\Entities\MyInheritedEntity" does not have a property "name"; do you need a custom scope?');

        $this->assertEntityHasPropertyWithValue($entity, 'name', 'test');
    }
}
