<?php

namespace Somnambulist\Domain\Tests\Events\Publishers\Symfony;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Events\Publishers\Symfony\DomainEventPublisher;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class DomainEventPublisherTest
 *
 * @package    Somnambulist\Domain\Tests\Events\Publishers\Symfony
 * @subpackage Somnambulist\Domain\Tests\Events\Publishers\Symfony\DomainEventPublisherTest
 */
class DomainEventPublisherTest extends TestCase
{

    /**
     * @var DomainEventPublisher
     */
    private $publisher;

    protected function setUp(): void
    {
        $listener   = new \DomainEventListener();
        $dispatcher = new EventDispatcher();
        $dispatcher->addListener('my.entity.created', [$listener, 'onMyEntityCreated']);
        $dispatcher->addListener('my.entity.added.another.entity', [$listener, 'onMyEntityAddedAnotherEntity']);

        $this->publisher = new DomainEventPublisher($dispatcher);
    }

    protected function tearDown(): void
    {
        $this->publisher = null;
    }

    /**
     * @group publishers-symfony-publisher
     */
    public function testPublishesDomainEvents()
    {
        $entity = new \MyEntity('test-id', 'test', 'bob', Carbon::now());

        $this->publisher->publishEventsFrom($entity);

        $this->expectOutputString("New item created with id: test-id, name: test, another: bob\n");

        $this->publisher->dispatch();

        $this->assertCount(0, $entity->releaseAndResetEvents());
    }

    /**
     * @group publishers-symfony-publisher
     */
    public function testFiresEventsWhenRelatedEntitiesChangedButRootNot()
    {
        $entity = new \MyEntity('test-id', 'test', 'bob', Carbon::now());

        $this->publisher->publishEventsFrom($entity);
        $this->publisher->dispatch();

        $this->assertCount(0, $entity->releaseAndResetEvents());

        $this->getActualOutput();

        sleep(1);

        $entity->addRelated('example', 'test-test', Carbon::now());

        $this->publisher->dispatch();

        $expected  = "New item created with id: test-id, name: test, another: bob\n";
        $expected .= "Added related entity with name: example, another: test-test to entity id: test-id\n";

        $this->expectOutputString($expected);

        $this->assertCount(0, $entity->releaseAndResetEvents());
    }

    /**
     * @group publishers-symfony-publisher
     */
    public function testFiresEventsInOrder()
    {
        $entity = new \MyEntity('test-id', 'test', 'bob', Carbon::now());

        $entity->addRelated('example1', 'test-test1', Carbon::now());
        $entity->addRelated('example2', 'test-test2', Carbon::now());
        $entity->addRelated('example3', 'test-test3', Carbon::now());

        $this->publisher->publishEventsFrom($entity);
        $this->publisher->dispatch();

        $expected  = "New item created with id: test-id, name: test, another: bob\n";
        $expected .= "Added related entity with name: example1, another: test-test1 to entity id: test-id\n";
        $expected .= "Added related entity with name: example2, another: test-test2 to entity id: test-id\n";
        $expected .= "Added related entity with name: example3, another: test-test3 to entity id: test-id\n";

        $this->expectOutputString($expected);

        $this->assertCount(0, $entity->releaseAndResetEvents());
    }

    /**
     * @group publishers-symfony-publisher
     */
    public function testCanStopListeningToEvents()
    {
        $entity = new \MyEntity('test-id', 'test', 'bob', Carbon::now());

        $this->publisher->publishEventsFrom($entity);
        $this->publisher->dispatch();

        $this->getActualOutput();

        $entity->addRelated('example1', 'test-test1', Carbon::now());
        $entity->addRelated('example2', 'test-test2', Carbon::now());
        $entity->addRelated('example3', 'test-test3', Carbon::now());

        $this->publisher->stopPublishingEventsFrom($entity);
        $this->publisher->dispatch();

        // appears to be no means to clear the output?
        $expected = "New item created with id: test-id, name: test, another: bob\n";

        $this->expectOutputString($expected);

        $this->assertCount(3, $entity->releaseAndResetEvents());
    }

    /**
     * @group publishers-symfony-publisher
     */
    public function testCanStopListeningToAllEvents()
    {
        $entity = new \MyEntity('test-id', 'test', 'bob', Carbon::now());

        $this->publisher->publishEventsFrom($entity);
        $this->publisher->dispatch();

        $this->getActualOutput();

        $entity->addRelated('example1', 'test-test1', Carbon::now());
        $entity->addRelated('example2', 'test-test2', Carbon::now());
        $entity->addRelated('example3', 'test-test3', Carbon::now());

        $this->publisher->stopPublishingAllEvents();
        $this->publisher->dispatch();

        // appears to be no means to clear the output?
        $expected = "New item created with id: test-id, name: test, another: bob\n";

        $this->expectOutputString($expected);

        $this->assertCount(3, $entity->releaseAndResetEvents());
    }
}
