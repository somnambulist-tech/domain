<?php declare(strict_types=1);

namespace Somnambulist\Domain\Events\Messenger;

use Somnambulist\Domain\Events\AbstractDomainEvent;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Transport\AmqpExt\AmqpStamp;

/**
 * Class EventBus
 *
 * @package    Somnambulist\Domain\Events\Messenger
 * @subpackage Somnambulist\Domain\Events\Messenger\EventBus
 */
final class EventBus implements \Somnambulist\Domain\Events\EventBus
{

    /**
     * @var MessageBusInterface
     */
    private $eventBus;

    /**
     * Constructor.
     *
     * @param MessageBusInterface $eventBus
     */
    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    /**
     * @param AbstractDomainEvent $event
     */
    public function dispatch(AbstractDomainEvent $event): void
    {
        $this->eventBus->dispatch($event, [new AmqpStamp($event->notificationName())]);
    }
}
