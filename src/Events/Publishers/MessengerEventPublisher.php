<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Events\Publishers;

use Somnambulist\Components\Domain\Events\AbstractEvent;

/**
 * Class DomainEventPublisher
 *
 * @package    Somnambulist\Components\Domain\Events\Publishers\Messenger
 * @subpackage Somnambulist\Components\Domain\Events\Publishers\Messenger\DomainEventPublisher
 */
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
