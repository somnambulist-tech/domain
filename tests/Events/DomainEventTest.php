<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Events;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Collection\FrozenCollection as Immutable;
use Somnambulist\Components\Events\AbstractEvent;
use Somnambulist\Components\Models\Types\Identity\Aggregate;
use Somnambulist\Components\Tests\Support\Stubs\Events\GroupPropertyEvent;
use Somnambulist\Components\Tests\Support\Stubs\Events\MyEntityCreatedEvent;
use Somnambulist\Components\Tests\Support\Stubs\Events\NamespacedEvent;
use Somnambulist\Components\Tests\Support\Stubs\Models\MyEntity;
use stdClass;
use function json_encode;
use function microtime;

#[Group('events')]
#[Group('events-event')]
class DomainEventTest extends TestCase
{
    public function testCanSetAggregateRoot()
    {
        $event = new MyEntityCreatedEvent([], [], new Aggregate(MyEntity::class, '73517dac-18c9-4e80-bea2-c384eb8e1e0d'));

        $this->assertEquals(MyEntity::class, $event->aggregate()->class());
        $this->assertEquals('73517dac-18c9-4e80-bea2-c384eb8e1e0d', $event->aggregate()->identity());
    }

    public function testCanGetName()
    {
        $event = new NamespacedEvent();

        $this->assertEquals('namespaced', $event->name());
        $this->assertEquals('app', $event->group());
    }

    public function testCanGetEventName()
    {
        $event = new NamespacedEvent();

        $this->assertEquals('app.namespaced', $event->longName());
    }

    public function testNotificationNameResolvesClassProperty()
    {
        $event = new GroupPropertyEvent();

        $this->assertEquals('my_group.group_property', $event->longName());
    }

    public function testCanCastToString()
    {
        $event = new NamespacedEvent();

        $this->assertEquals('namespaced', (string)$event);
    }

    public function testCreate()
    {
        $event = NamespacedEvent::create();

        $this->assertEquals('namespaced', $event->name());
    }

    public function testCanUpdateContext()
    {
        $event = NamespacedEvent::create(['foo' => 'bar'], ['context' => 'value']);
        $event = $event->appendContext(['user' => 'user@example.example']);

        $this->assertEquals(['context' => 'value', 'user' => 'user@example.example'], $event->context()->toArray());
    }

    public function testUpdatedContextPreservesOriginalTime()
    {
        $event1 = NamespacedEvent::create(['foo' => 'bar'], ['context' => 'value']);
        $event2 = $event1->appendContext(['user' => 'user@example.example']);

        $this->assertEquals($event2->createdAt(), $event1->createdAt());
    }

    public function testCanReplaceContext()
    {
        $event = NamespacedEvent::create(['foo' => 'bar'], ['context' => 'value']);
        $event = $event->replaceContext(['user' => 'user@example.example']);

        $this->assertEquals(['user' => 'user@example.example'], $event->context()->toArray());
    }

    public function testReplaceContextPreservesOriginalTime()
    {
        $event1 = NamespacedEvent::create(['foo' => 'bar'], ['context' => 'value']);
        $event2 = $event1->replaceContext(['user' => 'user@example.example']);

        $this->assertEquals($event2->createdAt(), $event1->createdAt());
    }

    public function testCanGetContext()
    {
        $event = new class extends AbstractEvent {};

        $this->assertInstanceOf(Immutable::class, $event->context());
    }

    public function testCanGetPayload()
    {
        $event = new class extends AbstractEvent {};

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
                'class' => 'Somnambulist\Components\Tests\Support\Stubs\Events\NamespacedEvent',
                'group' => 'app',
                'name'  => 'namespaced',
                'time'  => $event->createdAt(),
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
                'class' => 'Somnambulist\Components\Tests\Support\Stubs\Events\NamespacedEvent',
                'name'  => 'app.namespaced',
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

        $event = AbstractEvent::fromArray(NamespacedEvent::class, $data);

        $this->assertEquals(NamespacedEvent::class, $event->type());
        $this->assertEquals($ts, $event->createdAt());
        $this->assertNull($event->aggregate());
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
                'time'    => microtime(true),
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
        $this->assertEquals(stdClass::class, $event->type());
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
                'name'  => 'that_does_not_exist',
                'time'  => microtime(true),
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
        $this->assertEquals($t, $event->type());
        $this->assertEquals('a_group', $event->group());
        $this->assertEquals('that_does_not_exist', $event->name());
        $this->assertEquals('a_group.that_does_not_exist', $event->longName());
    }
}
