<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Events\Behaviours;

use Somnambulist\Components\Collection\MutableCollection as Collection;
use Somnambulist\Components\Domain\Entities\AggregateRoot;

/**
 * Trait CanGatherEventsForDispatch
 *
 * @package    Somnambulist\Components\Domain\Events\Behaviours
 * @subpackage Somnambulist\Components\Domain\Events\Behaviours\CanGatherEventsForDispatch
 */
trait CanGatherEventsForDispatch
{
    protected function gatherPublishedDomainEvents(Collection $entities): Collection
    {
        $events = new Collection();

        $entities->each(fn (AggregateRoot $entity) => $events->append(...$entity->releaseAndResetEvents()));

        return $events;
    }
}
