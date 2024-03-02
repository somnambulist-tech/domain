<?php declare(strict_types=1);

namespace Somnambulist\Components\Events\Publishers;

use Somnambulist\Components\Collection\MutableCollection as Collection;
use Somnambulist\Components\Events\Behaviours\CanDecorateEvents;
use Somnambulist\Components\Events\Behaviours\CanGatherEventsForDispatch;
use Somnambulist\Components\Events\Behaviours\CanSortEvents;
use Somnambulist\Components\Events\EventBus;
use Somnambulist\Components\Models\AggregateRoot;

abstract class AbstractEventPublisher
{
    use CanDecorateEvents;
    use CanGatherEventsForDispatch;
    use CanSortEvents;

    protected EventBus $eventBus;
    protected Collection $entities;

    public function __construct(EventBus $eventBus, iterable $decorators = [])
    {
        $this->entities   = new Collection();
        $this->eventBus   = $eventBus;
        $this->decorators = new Collection();

        foreach ($decorators as $decorator) {
            $this->addDecorator($decorator);
        }
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

    protected function clear(): void
    {
        $this->entities = new Collection();
    }
}
