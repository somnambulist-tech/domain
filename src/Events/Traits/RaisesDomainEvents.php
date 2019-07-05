<?php declare(strict_types=1);

namespace Somnambulist\Domain\Events\Traits;

use Somnambulist\Domain\Events\AbstractDomainEvent;

/**
 * Trait RaisesDomainEvents
 *
 * Based on the Gist by B. Eberlei https://gist.github.com/beberlei/53cd6580d87b1f5cd9ca
 *
 * @package    Somnambulist\Domain\Events\Traits
 * @subpackage Somnambulist\Domain\Events\Traits\RaisesDomainEvents
 */
trait RaisesDomainEvents
{

    /**
     * @var array|AbstractDomainEvent[]
     */
    private $events = [];

    /**
     * @inheritDoc
     */
    public function raise(AbstractDomainEvent $event): void
    {
        $this->events[] = $event;
    }

    /**
     * @inheritDoc
     */
    public function releaseAndResetEvents(): array
    {
        $pendingEvents = $this->events;

        $this->events = [];

        return $pendingEvents;
    }
}
