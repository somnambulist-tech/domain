<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Events\Adapters;

use Somnambulist\Components\Domain\Events\AbstractEvent;
use Somnambulist\Components\Domain\Events\EventBus;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class MessengerEventBus
 *
 * @package    Somnambulist\Components\Domain\Events\Adapters
 * @subpackage Somnambulist\Components\Domain\Events\Adapters\MessengerEventBus
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
