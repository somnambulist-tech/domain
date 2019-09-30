<?php declare(strict_types=1);

namespace Somnambulist\Domain\Events\Publishers\Behaviours;

use Somnambulist\Domain\Events\AbstractDomainEvent;
use Somnambulist\Domain\Events\EventBus;

/**
 * Trait BroadcastsDomainEvents
 *
 * @package    Somnambulist\Domain\Events\Publishers\Behaviours
 * @subpackage Somnambulist\Domain\Events\Publishers\Behaviours\BroadcastsDomainEvents
 */
trait BroadcastsDomainEvents
{

    /**
     * @var EventBus
     */
    protected $eventBus;

    /**
     * @param AbstractDomainEvent $event
     */
    protected function notify(AbstractDomainEvent $event): void
    {
        if ($this->eventBus instanceof EventBus) {
            $this->eventBus->dispatch($event);
        }
    }
}
