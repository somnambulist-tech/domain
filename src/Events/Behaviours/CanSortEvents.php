<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Events\Behaviours;

use Somnambulist\Collection\MutableCollection as Collection;
use Somnambulist\Components\Domain\Events\AbstractEvent;
use function bccomp;

/**
 * Trait CanSortEvents
 *
 * @package    Somnambulist\Components\Domain\Events\Behaviours
 * @subpackage Somnambulist\Components\Domain\Events\Behaviours\CanSortEvents
 */
trait CanSortEvents
{

    protected function sortEventsForDispatch(Collection $events): Collection
    {
        return $events->sort(fn (AbstractEvent $a, AbstractEvent $b) => bccomp((string)$a->getTime(), (string)$b->getTime(), 6));
    }
}
