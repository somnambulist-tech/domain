<?php declare(strict_types=1);

namespace Somnambulist\Components\Events\Behaviours;

use Somnambulist\Components\Collection\MutableCollection as Collection;
use Somnambulist\Components\Events\AbstractEvent;
use function bccomp;

trait CanSortEvents
{
    protected function sortEventsForDispatch(Collection $events): Collection
    {
        return $events->sort(fn (AbstractEvent $a, AbstractEvent $b) => bccomp((string)$a->createdAt(), (string)$b->createdAt(), 6));
    }
}
