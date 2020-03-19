<?php declare(strict_types=1);

namespace Somnambulist\Domain\Events\Adapters;

use Somnambulist\Domain\Events\AbstractEvent;
use Somnambulist\Domain\Events\EventBus;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class MessengerEventBus
 *
 * @package    Somnambulist\Domain\Events\Adapters
 * @subpackage Somnambulist\Domain\Events\Adapters\MessengerEventBus
 */
final class MessengerEventBus implements EventBus
{

    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->bus = $eventBus;
    }

    public function notify(AbstractEvent $event): void
    {
        $this->bus->dispatch($event, [new AmqpStamp($event->getEventName())]);
    }
}
