<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Events\Behaviours;

use Somnambulist\Components\Collection\MutableCollection as Collection;
use Somnambulist\Components\Domain\Events\Decorators\EventDecoratorInterface;

/**
 * Trait CanDecorateEvents
 *
 * @package    Somnambulist\Components\Domain\Events\Behaviours
 * @subpackage Somnambulist\Components\Domain\Events\Behaviours\CanDecorateEvents
 */
trait CanDecorateEvents
{
    protected Collection $decorators;

    protected function addDecorator(EventDecoratorInterface $decorator): void
    {
        $this->decorators->add($decorator);
    }

    protected function applyDecoratorsToEvents(Collection $events): Collection
    {
        return $this->decorators->pipeline($events, 'decorate');
    }
}
