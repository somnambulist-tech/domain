<?php declare(strict_types=1);

namespace Somnambulist\Domain\Utils\Tests\Assertions;

use Somnambulist\Collection\MutableCollection;
use Somnambulist\Domain\Events\AbstractDomainEvent;
use Somnambulist\Domain\Events\Contracts\RaisesDomainEvents;

/**
 * Trait AssertDomainEventHasAttributes
 *
 * Test a given Aggregate Root (or entity implementing RaisesDomainEvents) that it has
 * an event of type AND that the event has specific attributes and values.
 *
 * @package Somnambulist\Domain\Utils\Tests\Assertions
 * @subpackage Somnambulist\Domain\Utils\Tests\Assertions\AssertDomainEventHasAttributes
 */
trait AssertDomainEventHasAttributes
{

    /**
     * @param RaisesDomainEvents $entity      The entity that raises events
     * @param string             $event       The event class name to check for
     * @param array              $attributes  An array of key -> value pairs to check in the first matched event
     */
    public function assertDomainEventHasAttributes(RaisesDomainEvents $entity, string $event, array $attributes)
    {
        $events = new MutableCollection($entity->releaseAndResetEvents());

        /** @var AbstractDomainEvent $matched */
        $matched = $events->filter(function (AbstractDomainEvent $evt) use ($event) {
            return $evt instanceof $event;
        })->first();

        $this->assertInstanceOf($event, $matched);

        foreach ($attributes as $key => $value) {
            $this->assertTrue($matched->properties()->has($key), sprintf('Event %s was expected to have property %s', $event, $key));
            $this->assertEquals(
                $value, $matched->properties()->get($key),
                sprintf('Event %s property %s was expected to be %s, but %s received', $event, $key, $value, $matched->property($key))
            );
        }
    }
}
