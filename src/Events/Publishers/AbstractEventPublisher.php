<?php declare(strict_types=1);

namespace Somnambulist\Domain\Events\Publishers;

use Somnambulist\Collection\MutableCollection as Collection;
use Somnambulist\Domain\Entities\AggregateRoot;
use Somnambulist\Domain\Events\AbstractEvent;
use Somnambulist\Domain\Events\EventBus;

/**
 * Class AbstractEventPublisher
 *
 * @package    Somnambulist\Domain\Events\Publishers
 * @subpackage Somnambulist\Domain\Events\Publishers\AbstractEventPublisher
 */
abstract class AbstractEventPublisher
{

    protected EventBus $eventBus;
    protected Collection $entities;

    public function __construct(EventBus $eventBus)
    {
        $this->entities = new Collection();
        $this->eventBus = $eventBus;
    }

    abstract public function dispatch(): void;

    public function publishEventsFrom(AggregateRoot $entity): void
    {
        $this->entities->add($entity);
    }

    public function stopPublishingEventsFrom(AggregateRoot $entity): void
    {
        $this->entities->remove($entity);
    }

    public function stopPublishingAllEvents(): void
    {
        $this->clear();
    }

    protected function entities(): Collection
    {
        return $this->entities;
    }

    protected function gatherPublishedDomainEvents(Collection $entities): Collection
    {
        $events = new Collection();

        $entities->each(fn (AggregateRoot $entity) => $events->append(...$entity->releaseAndResetEvents()));

        return $events;
    }

    protected function orderDomainEvents(Collection $events): Collection
    {
       return $events->sort(fn (AbstractEvent $a, AbstractEvent $b) => bccomp((string)$a->getTime(), (string)$b->getTime(), 6));
    }

    protected function clear(): void
    {
        $this->entities = new Collection();
    }
}
