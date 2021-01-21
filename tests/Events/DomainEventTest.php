<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Events;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Collection\FrozenCollection as Immutable;
use Somnambulist\Components\Domain\Entities\Types\Identity\Aggregate;
use Somnambulist\Components\Domain\Events\AbstractEvent;
use Somnambulist\Components\Domain\Tests\Support\Stubs\Events\GroupPropertyEvent;
use Somnambulist\Components\Domain\Tests\Support\Stubs\Events\MyEntityCreatedEvent;
use Somnambulist\Components\Domain\Tests\Support\Stubs\Events\NamespacedEvent;
use Somnambulist\Components\Domain\Tests\Support\Stubs\Models\MyEntity;
use stdClass;
use function json_encode;
use function microtime;

/**
 * Class DomainEventTest
 *
 * @package    Somnambulist\Tests\DomainEvents
 * @subpackage Somnambulist\Tests\DomainEvents\DomainEventTest
 *
 * @group events
 * @group events-event
 */
class DomainEventTest extends TestCase
{

    public function testCanSetAggregateRoot()
    {
        $event = new MyEntityCreatedEvent([], [], new Aggregate(MyEntity::class, '73517dac-18c9-4e80-bea2-c384eb8e1e0d'));

        $this->assertEquals(MyEntity::class, $event->getAggregate()->class());
        $this->assertEquals('73517dac-18c9-4e80-bea2-c384eb8e1e0d', $event->getAggregate()->identity());
    }

    public function testCanGetName()
    {
        $event = new NamespacedEvent();

        $this->assertEquals('Namespaced', $event->getName());
        $this->assertEquals('app', $event->getGroup());
    }

    public function testCanGetEventName()
    {
        $event = new NamespacedEvent();

        $this->assertEquals('app.namespaced', $event->getEventName());
    }

    public function testNotificationNameResolvesClassProperty()
    {
        $event = new GroupPropertyEvent();

        $this->assertEquals('my_group.group_property', $event->getEventName());
    }

    public function testCanCastToString()
    {
        $event = new NamespacedEvent();

        $this->assertEquals('Namespaced', (string)$event);
    }

    public function testCreate()
    {
        $event = NamespacedEvent::create();

        $this->assertEquals('Namespaced', $event->getName());
    }

    public function testCanUpdateContext()
    {
        $event = NamespacedEvent::create(['foo' => 'bar'], ['context' => 'value']);
        $event->appendContext(['user' => 'user@example.example']);

        $this->assertEquals(['context' => 'value', 'user' => 'user@example.example'], $event->context()->toArray());
    }

    public function testCanGetContext()
    {
        $event = $this->getMockForAbstractClass(AbstractEvent::class);

        $this->assertInstanceOf(Immutable::class, $event->context());
    }

    public function testCanGetPayload()
    {
        $event = $this->getMockForAbstractClass(AbstractEvent::class);

        $this->assertInstanceOf(Immutable::class, $event->payload());
    }

    public function testToArray()
    {
        $event = NamespacedEvent::create(['foo' => 'bar'], ['context' => 'value', 'user' => 'user@example.example']);

        $expected = [
            'aggregate' => [
                'class' => null,
                'id'    => null,
            ],
            'event'     => [
                'class' => 'Somnambulist\Components\Domain\Tests\Support\Stubs\Events\NamespacedEvent',
                'group' => 'app',
                'name'  => 'Namespaced',
                'time'  => $event->getTime(),
            ],
            'payload'   => [
                'foo' => 'bar',
            ],
            'context'   => [
                'context' => 'value',
                'user'    => 'user@example.example',
            ],
        ];

        $this->assertEquals($expected, $event->toArray());
    }

    public function testToJson()
    {
        $event = NamespacedEvent::create(['foo' => 'bar'], ['context' => 'value', 'user' => 'user@example.example']);

        $this->assertEquals(json_encode($event->toArray()), $event->toJson());
    }

    public function testFromArray()
    {
        $data = [
            'aggregate' => [
                'class' => null,
                'id'    => null,
            ],
            'event'     => [
                'class'   => 'Somnambulist\Components\Domain\Tests\Support\Stubs\Events\NamespacedEvent',
                'name'    => 'app.namespaced',
                'time'    => $ts = microtime(true),
            ],
            'context'   => [
                'context' => 'value',
                'user'    => 'user@example.example',
            ],
            'payload'   => [
                'foo' => 'bar',
            ],
        ];

        $event = AbstractEvent::fromArray(NamespacedEvent::class, $data);

        $this->assertEquals(NamespacedEvent::class, $event->getType());
        $this->assertEquals($ts, $event->getTime());
        $this->assertNull($event->getAggregate());
        $this->assertEquals('bar', $event->payload()->get('foo'));
        $this->assertEquals('value', $event->context()->get('context'));
        $this->assertEquals('user@example.example', $event->context()->get('user'));
    }

    public function testFromArrayStillReturnsAbstractEventInstance()
    {
        $data = [
            'aggregate' => [
                'class' => null,
                'id'    => null,
            ],
            'event'     => [
                'class'   => 'Events\NamespacedEvent',
                'name'    => 'app.namespaced',
                'version' => 2,
                'time'    => $ts = microtime(true),
            ],
            'context'   => [
                'context' => 'value',
                'user'    => 'user@example.example',
            ],
            'payload'   => [
                'foo' => 'bar',
            ],
        ];

        $event = AbstractEvent::fromArray(stdClass::class, $data);

        $this->assertInstanceOf(AbstractEvent::class, $event);
        $this->assertEquals(stdClass::class, $event->getType());
    }

    public function testFromArrayReturnsAnonymousClassIfEventDoesNotExist()
    {
        $data = [
            'aggregate' => [
                'class' => null,
                'id'    => null,
            ],
            'event'     => [
                'class' => 'Some\Class\ThatDoesNotExist',
                'group' => 'a_group',
                'name'  => 'ThatDoesNotExist',
                'time'  => $ts = microtime(true),
            ],
            'context'   => [
                'context' => 'value',
                'user'    => 'user@example.example',
            ],
            'payload'   => [
                'foo' => 'bar',
            ],
        ];

        $event = AbstractEvent::fromArray($t = 'Some\Class\ThatDoesNotExist', $data);

        $this->assertInstanceOf(AbstractEvent::class, $event);
        $this->assertEquals($t, $event->getType());
        $this->assertEquals('a_group', $event->getGroup());
        $this->assertEquals('ThatDoesNotExist', $event->getName());
        $this->assertEquals('a_group.that_does_not_exist', $event->getEventName());
    }
}
