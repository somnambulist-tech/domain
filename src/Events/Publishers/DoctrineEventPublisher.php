<?php declare(strict_types=1);

namespace Somnambulist\Components\Events\Publishers;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Events;
use Somnambulist\Components\Collection\MutableCollection as Collection;
use Somnambulist\Components\Models\AggregateRoot;
use Somnambulist\Components\Events\AbstractEvent;
use Somnambulist\Components\Events\Behaviours\CanDecorateEvents;
use Somnambulist\Components\Events\Behaviours\CanGatherEventsForDispatch;
use Somnambulist\Components\Events\Behaviours\CanSortEvents;
use Somnambulist\Components\Events\EventBus;

/**
 * Based on the Gist by B. Eberlei https://gist.github.com/beberlei/53cd6580d87b1f5cd9ca
 */
class DoctrineEventPublisher implements EventSubscriber
{
    use CanDecorateEvents;
    use CanGatherEventsForDispatch;
    use CanSortEvents;

    private Collection $entities;

    public function __construct(private EventBus $eventBus, iterable $decorators = [])
    {
        $this->entities   = new Collection();
        $this->decorators = new Collection();

        foreach ($decorators as $decorator) {
            $this->addDecorator($decorator);
        }
    }

    public function getSubscribedEvents(): array
    {
        return [Events::prePersist, Events::preRemove, Events::preFlush, Events::postFlush];
    }

    public function prePersist(LifecycleEventArgs $event): void
    {
        $entity = $event->getObject();

        if ($entity instanceof AggregateRoot && $this->entities->doesNotContain($entity)) {
            $this->entities->add($entity);
        }
    }

    public function preRemove(LifecycleEventArgs $event): void
    {
        $entity = $event->getObject();
        if ($entity instanceof AggregateRoot && $this->entities->doesNotContain($entity)) {
            $this->entities->add($entity);
        }
    }

    public function preFlush(PreFlushEventArgs $event): void
    {
        $uow = $event->getObjectManager()->getUnitOfWork();

        foreach ($uow->getIdentityMap() as $class => $entities) {
            if (!is_a($class, AggregateRoot::class, true)) {
                continue; // @codeCoverageIgnore
            }

            foreach ($entities as $entity) {
                if ($this->entities->doesNotContain($event)) {
                    $this->entities->add($entity);
                }
            }
        }
    }

    public function postFlush(PostFlushEventArgs $event): void
    {
        $this
            ->applyDecoratorsToEvents($this->sortEventsForDispatch($this->gatherPublishedDomainEvents($this->entities)))
            ->each(fn (AbstractEvent $event) => $this->eventBus->notify($event))
        ;

        $this->clear();
    }

    protected function clear(): void
    {
        $this->entities = new Collection();
    }
}
