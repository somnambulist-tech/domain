<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Events;

/**
 * Interface EventBus
 *
 * @package    Somnambulist\Components\Domain\Events
 * @subpackage Somnambulist\Components\Domain\Events\EventBus
 */
interface EventBus
{
    /**
     * Broadcast the message to all listeners
     *
     * @param AbstractEvent $event
     */
    public function notify(AbstractEvent $event): void;

    /**
     * Dispatch the event only after the current handler has finished without an exception
     *
     * @param AbstractEvent $event
     */
    public function afterCurrent(AbstractEvent $event): void;
}
