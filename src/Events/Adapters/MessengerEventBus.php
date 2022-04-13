<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Events\Adapters;

use Somnambulist\Components\Domain\Events\AbstractEvent;
use Somnambulist\Components\Domain\Events\EventBus;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

/**
 * Class MessengerEventBus
 *
 * @package    Somnambulist\Components\Domain\Events\Adapters
 * @subpackage Somnambulist\Components\Domain\Events\Adapters\MessengerEventBus
 */
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
