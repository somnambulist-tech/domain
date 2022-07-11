<?php declare(strict_types=1);

namespace Somnambulist\Components\Events;

use function class_alias;

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

class_alias(EventDecoratorInterface::class, 'Somnambulist\Components\Events\Decorators\EventDecoratorInterface');
