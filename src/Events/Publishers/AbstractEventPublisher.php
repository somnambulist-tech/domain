<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Events\Publishers;

use Somnambulist\Collection\MutableCollection as Collection;
use Somnambulist\Components\Domain\Entities\AggregateRoot;
use Somnambulist\Components\Domain\Events\Behaviours\CanDecorateEvents;
use Somnambulist\Components\Domain\Events\Behaviours\CanGatherEventsForDispatch;
use Somnambulist\Components\Domain\Events\Behaviours\CanSortEvents;
use Somnambulist\Components\Domain\Events\EventBus;

/**
 * Class AbstractEventPublisher
 *
 * @package    Somnambulist\Components\Domain\Events\Publishers
 * @subpackage Somnambulist\Components\Domain\Events\Publishers\AbstractEventPublisher
 */
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
