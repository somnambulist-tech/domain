<?php

namespace Somnambulist\Domain\Tests\Events;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

/**
 * Class RaisesDomainEventsTest
 *
 * @package    Somnambulist\Tests\DomainEvents
 * @subpackage Somnambulist\Tests\DomainEvents\RaisesDomainEventsTest
 */
class RaisesDomainEventsTest extends TestCase
{

    /**
     * @group traits
     * @group raises-events
     */
    public function testCanRaiseEvents()
    {
        $entity = new \MyEntity('identity', 'test', 'another field', Carbon::now());
        $events = $entity->releaseAndResetEvents();

        $this->assertCount(1, $events);
        $this->assertInstanceOf(\MyEntityCreatedEvent::class, $events[0]);
    }

    /**
     * @group traits
     * @group raises-events
     */
    public function testReleasingEventsResetsInternalEvents()
    {
        $entity = new \MyEntity('identity', 'test', 'another field', Carbon::now());
        $events = $entity->releaseAndResetEvents();

        $this->assertCount(1, $events);
        $this->assertCount(0, $entity->releaseAndResetEvents());
    }

    /**
     * @group traits
     * @group raises-events
     */
    public function testCanRaiseMultipleEvents()
    {
        $entity = new \MyEntity('identity', 'test', 'another field', Carbon::now());
        $entity->updateName('bob');

        $events = $entity->releaseAndResetEvents();

        $this->assertCount(2, $events);
        $this->assertInstanceOf(\MyEntityCreatedEvent::class, $events[0]);
        $this->assertInstanceOf(\MyEntityNameUpdatedEvent::class, $events[1]);
    }
}
