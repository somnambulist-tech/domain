<?php declare(strict_types=1);

namespace Somnambulist\Domain\Utils\Tests\Assertions;

use Somnambulist\Collection\MutableCollection;
use Somnambulist\Domain\Events\AbstractDomainEvent;
use Somnambulist\Domain\Events\Contracts\RaisesDomainEvents;
use function get_class;

/**
 * Trait AssertDoesNotHaveDomainEventOfType
 *
 * Asserts that an entity did NOT raise an event of the type specified.
 *
 * @package Somnambulist\Domain\Utils\Tests\Assertions
 * @subpackage Somnambulist\Domain\Utils\Tests\Assertions\AssertDoesNotHaveDomainEventOfType
 */
trait AssertDoesNotHaveDomainEventOfType
{

    /**
     * @param RaisesDomainEvents $entity The entity that raises events
     * @param string             $event  The event class name to check for
     */
    public function assertDoesNotHaveDomainEventOfType(RaisesDomainEvents $entity, string $event)
    {
        $events = new MutableCollection($entity->releaseAndResetEvents());

        $matched = $events->filter(function (AbstractDomainEvent $evt) use ($event) {
            return $evt instanceof $event;
        })->count();

        $this->assertEquals(0, $matched, sprintf('"%s" raised "%s" events when none were expected', get_class($entity), $matched));
    }
}
