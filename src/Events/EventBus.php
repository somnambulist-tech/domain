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
     */
    public function dispatch(AbstractDomainEvent $event): void;
}
