<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Events\Publishers;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\DateTime\DateTime;
use Somnambulist\Components\Models\Types\Identity\Uuid;
use Somnambulist\Components\Events\Publishers\MessengerEventPublisher;
use Somnambulist\Components\Tests\Support\Stubs\EventListeners\DomainEventListener;
use Somnambulist\Components\Tests\Support\Stubs\Models\MyEntity;
use function sleep;

class MessengerEventPublisherTest extends TestCase
{
    private MessengerEventPublisher $dispatcher;

    protected function setUp(): void
    {
        $this->dispatcher = new MessengerEventPublisher(new DomainEventListener());
    }

    public function testFiresEvents()
    {
        $entity = new MyEntity(new Uuid('e9177266-5a64-420d-afda-04feb7edf14d'), 'test', 'bob');

        $this->expectOutputString("New item created with id: e9177266-5a64-420d-afda-04feb7edf14d, name: test, another: bob\n");

        $this->dispatcher->publishEventsFrom($entity);
        $this->dispatcher->dispatch();

        $this->assertCount(0, $entity->releaseAndResetEvents());
    }

    public function testFiresEventsWhenRelatedEntitiesChangedButRootNot()
    {
        $entity = new MyEntity(new Uuid('e9177266-5a64-420d-afda-04feb7edf14d'), 'test', 'bob');

        $this->dispatcher->publishEventsFrom($entity);
        $this->dispatcher->dispatch();

        $this->assertCount(0, $entity->releaseAndResetEvents());

        $this->getActualOutput();

        sleep(1);

        $entity->addRelated('example', 'test-test', DateTime::now());

        $this->dispatcher->dispatch();

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

        $this->dispatcher->publishEventsFrom($entity);
        $this->dispatcher->dispatch();

        $expected  = "New item created with id: e9177266-5a64-420d-afda-04feb7edf14d, name: test, another: bob\n";
        $expected .= "Added related entity with name: example1, another: test-test1 to entity id: e9177266-5a64-420d-afda-04feb7edf14d\n";
        $expected .= "Added related entity with name: example2, another: test-test2 to entity id: e9177266-5a64-420d-afda-04feb7edf14d\n";
        $expected .= "Added related entity with name: example3, another: test-test3 to entity id: e9177266-5a64-420d-afda-04feb7edf14d\n";

        $this->expectOutputString($expected);

        $this->assertCount(0, $entity->releaseAndResetEvents());
    }
}
