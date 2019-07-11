<?php declare(strict_types=1);

namespace Somnambulist\Domain\Events;

use Somnambulist\Collection\MutableCollection as Collection;
use Somnambulist\Domain\Events\Contracts\RaisesDomainEvents;

/**
 * Class AbstractEventPublisher
 *
 * @package    Somnambulist\Domain\Events
 * @subpackage Somnambulist\Domain\Events\AbstractEventPublisher
 */
abstract class AbstractEventPublisher
{

    /**
     * @var object An EventDispatcher instance
     */
    protected $dispatcher;

    /**
     * @var Collection|RaisesDomainEvents[]
     */
    private $entities;

    /**
     * Constructor.
     *
     * @param object $dispatcher
     */
    public function __construct($dispatcher)
    {
        $this->entities   = new Collection();
        $this->dispatcher = $dispatcher;
    }

    /**
     * Dispatch (publish) all domain events to the registered event dispatcher
     *
     * @return void
     */
    abstract public function dispatch(): void;

    /**
     * Registers the entity for event broadcast
     *
     * @param RaisesDomainEvents $entity
     */
    public function publishEventsFrom(RaisesDomainEvents $entity): void
    {
        $this->entities->add($entity);
    }

    /**
     * Removes the entity from the registry preventing events from being published
     *
     * @param RaisesDomainEvents $entity
     */
    public function stopPublishingEventsFrom(RaisesDomainEvents $entity): void
    {
        $this->entities->remove($entity);
    }

    /**
     * Removes all entities from the internal registry
     */
    public function stopPublishingAllEvents(): void
    {
        $this->clear();
    }

    /**
     * @return Collection|RaisesDomainEvents[]
     */
    protected function entities()
    {
        return $this->entities;
    }

    /**
     * @param Collection $entities
     *
     * @return Collection
     */
    protected function gatherPublishedDomainEvents(Collection $entities)
    {
        $events = new Collection();

        $entities->each(function ($entity) use ($events) {
            /** @var RaisesDomainEvents $entity */
            $events->merge($entity->releaseAndResetEvents());

            return true;
        });

        return $events;
    }

    /**
     * @param Collection $events
     *
     * @return Collection
     */
    protected function orderDomainEvents(Collection $events): Collection
    {
       return $events->sortUsing(function ($a, $b) {
            /** @var AbstractDomainEvent $a */
            /** @var AbstractDomainEvent $b */
            return bccomp((string)$a->time(), (string)$b->time(), 6);
        });
    }

    /**
     * Removes all record entities from the listener
     */
    protected function clear(): void
    {
        $this->entities->reset();
    }
}
