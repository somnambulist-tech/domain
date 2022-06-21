<?php declare(strict_types=1);

namespace Somnambulist\Components\Events\Publishers;

use Somnambulist\Components\Events\AbstractEvent;

class MessengerEventPublisher extends AbstractEventPublisher
{
    public function dispatch(): void
    {
        $this
            ->applyDecoratorsToEvents($this->sortEventsForDispatch($this->gatherPublishedDomainEvents($this->entities())))
            ->each(fn (AbstractEvent $event) => $this->eventBus->notify($event))
        ;
    }
}
