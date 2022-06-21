<?php declare(strict_types=1);

namespace Somnambulist\Components\Events\Adapters;

use Somnambulist\Components\Events\AbstractEvent;
use Somnambulist\Components\Events\EventBus;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

final class MessengerEventBus implements EventBus
{
    public function __construct(private MessageBusInterface $eventBus)
    {
    }

    public function notify(AbstractEvent $event): void
    {
        $this->eventBus->dispatch($event, [new AmqpStamp($event->longName())]);
    }

    public function afterCurrent(AbstractEvent $event): void
    {
        $this->eventBus->dispatch($event, [new AmqpStamp($event->longName()), new DispatchAfterCurrentBusStamp()]);
    }
}
