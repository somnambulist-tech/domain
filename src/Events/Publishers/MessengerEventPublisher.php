<?php declare(strict_types=1);

namespace Somnambulist\Domain\Events\Publishers;

use Somnambulist\Domain\Events\AbstractEvent;

/**
 * Class DomainEventPublisher
 *
 * @package    Somnambulist\Domain\Events\Publishers\Messenger
 * @subpackage Somnambulist\Domain\Events\Publishers\Messenger\DomainEventPublisher
 */
class MessengerEventPublisher extends AbstractEventPublisher
{

    public function dispatch(): void
    {
        $this
            ->orderDomainEvents($this->gatherPublishedDomainEvents($this->entities()))
            ->each(fn (AbstractEvent $event) => $this->eventBus->notify($event))
        ;
    }
}
