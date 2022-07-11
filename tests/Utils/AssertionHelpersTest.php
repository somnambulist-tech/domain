<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Utils;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\Identity\Uuid;
use Somnambulist\Components\Tests\Support\Stubs\Events\MyEntityCreatedEvent;
use Somnambulist\Components\Tests\Support\Stubs\Events\MyEntityNameUpdatedEvent;
use Somnambulist\Components\Tests\Support\Stubs\Models\AbstractEntity;
use Somnambulist\Components\Tests\Support\Stubs\Models\MyEntity;
use Somnambulist\Components\Tests\Support\Stubs\Models\MyInheritedEntity;
use Somnambulist\Components\Utils\Tests\Assertions\AssertDoesNotHaveDomainEventOfType;
use Somnambulist\Components\Utils\Tests\Assertions\AssertDomainEventHasAttributes;
use Somnambulist\Components\Utils\Tests\Assertions\AssertEntityHasPropertyWithValue;
use Somnambulist\Components\Utils\Tests\Assertions\AssertHasDomainEventOfType;

/**
 * @group utils
 */
class AssertionHelpersTest extends TestCase
{
    use AssertDoesNotHaveDomainEventOfType;
    use AssertDomainEventHasAttributes;
    use AssertHasDomainEventOfType;
    use AssertEntityHasPropertyWithValue;

    public function testHasDomainEvent()
    {
        $entity = new MyEntity(new Uuid('e9177266-5a64-420d-afda-04feb7edf14d'), 'test', 'bob');

        $this->assertHasDomainEventOfType($entity, MyEntityCreatedEvent::class);
    }

    public function testHasDomainEventWithCount()
    {
        $entity = new MyEntity(new Uuid('e9177266-5a64-420d-afda-04feb7edf14d'), 'test', 'bob');

        $this->assertHasDomainEventOfType($entity, MyEntityCreatedEvent::class, 1);
    }

    public function testDoesNotHaveDomainEvent()
    {
        $entity = new MyEntity(new Uuid('e9177266-5a64-420d-afda-04feb7edf14d'), 'test', 'bob');

        $this->assertDoesNotHaveDomainEventOfType($entity, MyEntityNameUpdatedEvent::class);
    }

    public function testEventHasAttributes()
    {
        $entity = new MyEntity(new Uuid('e9177266-5a64-420d-afda-04feb7edf14d'), 'test', 'bob');

        $this->assertDomainEventHasAttributes($entity, MyEntityCreatedEvent::class, [
            'id' => 'e9177266-5a64-420d-afda-04feb7edf14d',
            'name' => 'test',
            'another' => 'bob',
        ]);
    }

    public function testEntityHasPropertyValue()
    {
        $entity = new MyEntity($u = new Uuid('e9177266-5a64-420d-afda-04feb7edf14d'), 'test', 'bob');

        $this->assertEntityHasPropertyWithValue($entity, 'id', $u);
    }

    public function testEntityHasPropertyValueWorksWithObjects()
    {
        $entity = new MyEntity(new Uuid('e9177266-5a64-420d-afda-04feb7edf14d'), 'test', 'bob');

        $this->assertEntityHasPropertyWithValue($entity, 'createdAt', $entity->getCreatedAt());
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
        $this->expectExceptionMessage('Object of type "Somnambulist\Components\Tests\Support\Stubs\Models\MyInheritedEntity" does not have a property "name"; do you need a custom scope?');

        $this->assertEntityHasPropertyWithValue($entity, 'name', 'test');
    }
}
