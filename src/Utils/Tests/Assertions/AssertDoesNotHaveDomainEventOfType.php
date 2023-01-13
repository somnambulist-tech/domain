<?php declare(strict_types=1);

namespace Somnambulist\Components\Utils\Tests\Assertions;

use Somnambulist\Components\Collection\MutableCollection;
use Somnambulist\Components\Models\AggregateRoot;
use Somnambulist\Components\Events\AbstractEvent;
use function get_class;

/**
 * Test Helper
 *
 * Asserts that an entity did NOT raise an event of the type specified.
 */
trait AssertDoesNotHaveDomainEventOfType
{
    /**
     * @param AggregateRoot $entity The entity that raises events
     * @param string        $event  The event class name to check for
     */
    public function assertDoesNotHaveDomainEventOfType(AggregateRoot $entity, string $event): void
    {
        $events  = new MutableCollection($entity->releaseAndResetEvents());
        $matched = $events->filter(fn (AbstractEvent $evt) => $evt instanceof $event)->count();

        $this->assertEquals(0, $matched, sprintf('"%s" raised "%s" events when none were expected', get_class($entity), $matched));
    }
}
