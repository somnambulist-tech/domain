<?php declare(strict_types=1);

namespace Somnambulist\Domain\Events\Contracts;

use Somnambulist\Domain\Events\AbstractDomainEvent;

/**
 * Interface RaisesDomainEvents
 *
 * @package    Somnambulist\Domain\Events\Contracts
 * @subpackage Somnambulist\Domain\Events\Contracts\RaisesDomainEvents
 */
interface RaisesDomainEvents
{

    /**
     * Raise an event after an action has happened on an aggregate
     *
     * This could be triggered by a back-call to the aggregate from a child-object.
     * Events are always named for something that _has_ happened so should be raised
     * after the action was performed.
     *
     * @param AbstractDomainEvent $event
     */
    public function raise(AbstractDomainEvent $event): void;

    /**
     * Return all raised events and reset the internal stack
     *
     * @return array|AbstractDomainEvent[]
     */
    public function releaseAndResetEvents(): array;
}
