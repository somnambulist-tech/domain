<?php declare(strict_types=1);

namespace Somnambulist\Components\Events\Behaviours;

use Somnambulist\Components\Collection\MutableCollection as Collection;
use Somnambulist\Components\Models\AggregateRoot;

trait CanGatherEventsForDispatch
{
    protected function gatherPublishedDomainEvents(Collection $entities): Collection
    {
        $events = new Collection();

        $entities->each(fn (AggregateRoot $entity) => $events->append(...$entity->releaseAndResetEvents()));

        return $events;
    }
}
