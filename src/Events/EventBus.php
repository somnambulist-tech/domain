<?php declare(strict_types=1);

namespace Somnambulist\Domain\Events;

/**
 * Interface EventBus
 *
 * @package    Somnambulist\Domain\Events
 * @subpackage Somnambulist\Domain\Events\EventBus
 */
interface EventBus
{

    /**
     * @param AbstractDomainEvent $event
     * @deprecated {@see notify()} will be removed in 3.0
     */
    public function dispatch(AbstractDomainEvent $event): void;

    /**
     * @param AbstractDomainEvent $event
     */
    public function notify(AbstractDomainEvent $event): void;
}
