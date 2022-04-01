<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Events\Decorators;

use Somnambulist\Components\Domain\Events\AbstractEvent;

/**
 * Interface EventDecoratorInterface
 *
 * @package    Somnambulist\Components\Domain\Events\Decorators
 * @subpackage Somnambulist\Components\Domain\Events\Decorators\EventDecoratorInterface
 */
interface EventDecoratorInterface
{
    /**
     * Decorates the event with contextual information before the event is dispatched
     *
     * @param AbstractEvent $event
     *
     * @return AbstractEvent
     */
    public function decorate(AbstractEvent $event): AbstractEvent;
}
