<?php declare(strict_types=1);

namespace Somnambulist\Domain\Events\Publishers\Messenger;

use Somnambulist\Domain\Events\AbstractDomainEvent;
use Somnambulist\Domain\Events\AbstractEventPublisher;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Transport\AmqpExt\AmqpStamp;

/**
 * Class DomainEventPublisher
 *
 * @package    Somnambulist\Domain\Events\Publishers\Messenger
 * @subpackage Somnambulist\Domain\Events\Publishers\Messenger\DomainEventPublisher
 */
class DomainEventPublisher extends AbstractEventPublisher
{

    /**
     * Constructor.
     *
     * @param MessageBusInterface $eventBus
     */
    public function __construct(MessageBusInterface $eventBus)
    {
        parent::__construct($eventBus);
    }

    public function dispatch(): void
    {
        $events = $this->orderDomainEvents($this->gatherPublishedDomainEvents($this->entities()));

        $events->each(function (AbstractDomainEvent $event) {
            $this->dispatcher()->dispatch($event, [new AmqpStamp($event->notificationName())]);
        });
    }

    /**
     * @return MessageBusInterface|object
     */
    private function dispatcher()
    {
        return $this->dispatcher;
    }
}
