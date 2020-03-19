<?php declare(strict_types=1);

namespace Somnambulist\Domain\Utils\Tests\Assertions;

use Somnambulist\Collection\MutableCollection;
use Somnambulist\Domain\Entities\AggregateRoot;
use Somnambulist\Domain\Events\AbstractEvent;
use function get_class;
use function sprintf;

/**
 * Trait AssertHasDomainEventOfType
 *
 * Tests that a particular type of event was raised by an entity operation. Optionally:
 * that a specific number of the events were raised. The count match must be greater than
 * 0 (zero).
 *
 * @package    Somnambulist\Domain\Utils\Tests\Assertions
 * @subpackage Somnambulist\Domain\Utils\Tests\Assertions\AssertHasDomainEventOfType
 */
trait AssertHasDomainEventOfType
{

    /**
     * @param AggregateRoot $entity The entity that raises events
     * @param string        $event  The event class name to check for
     * @param int|null      $count  Optional: must have this many events of the type
     */
    public function assertHasDomainEventOfType(AggregateRoot $entity, string $event, int $count = null)
    {
        $events  = new MutableCollection($entity->releaseAndResetEvents());
        $matched = $events->filter(fn (AbstractEvent $evt) => $evt instanceof $event)->count();

        $this->assertGreaterThan(
            0, $matched, sprintf('Expected at least one event of type "%s" from "%s" to be raised, none were', $event, get_class($entity))
        );

        if (!is_null($count) && $count > 0) {
            $this->assertEquals(
                $count, $matched, sprintf('Expected "%s" events to be raised from "%s", only "%s" were', $count, get_class($entity), $matched)
            );
        }
    }
}
