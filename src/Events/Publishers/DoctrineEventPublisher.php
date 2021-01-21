<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Events\Publishers;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Events;
use Somnambulist\Components\Collection\MutableCollection as Collection;
use Somnambulist\Components\Domain\Entities\AggregateRoot;
use Somnambulist\Components\Domain\Events\AbstractEvent;
use Somnambulist\Components\Domain\Events\Behaviours\CanDecorateEvents;
use Somnambulist\Components\Domain\Events\Behaviours\CanGatherEventsForDispatch;
use Somnambulist\Components\Domain\Events\Behaviours\CanSortEvents;
use Somnambulist\Components\Domain\Events\EventBus;

/**
 * Class DomainEventListener
 *
 * Based on the Gist by B. Eberlei https://gist.github.com/beberlei/53cd6580d87b1f5cd9ca
 *
 * @package    Somnambulist\Components\Domain\Events\Publishers\Doctrine\Subscribers
 * @subpackage Somnambulist\Components\Domain\Events\Publishers\Doctrine\Subscribers\DomainEventPublisher
 */
class DoctrineEventPublisher implements EventSubscriber
{

    use CanDecorateEvents;
    use CanGatherEventsForDispatch;
    use CanSortEvents;

    private EventBus $eventBus;
    private Collection $entities;

    public function __construct(EventBus $eventBus, iterable $decorators = [])
    {
        $this->entities   = new Collection();
        $this->eventBus   = $eventBus;
        $this->decorators = new Collection();

        foreach ($decorators as $decorator) {
            $this->addDecorator($decorator);
        }
    }

    public function getSubscribedEvents()
    {
        return [Events::prePersist, Events::preFlush, Events::postFlush];
    }

    public function prePersist(LifecycleEventArgs $event): void
    {
        $entity = $event->getEntity();

        if ($entity instanceof AggregateRoot) {
            $this->entities->add($entity);
        }
    }

    public function preFlush(PreFlushEventArgs $event): void
    {
        $uow = $event->getEntityManager()->getUnitOfWork();

        foreach ($uow->getIdentityMap() as $class => $entities) {
            if (!is_a($class, AggregateRoot::class, $string = true)) {
                continue; // @codeCoverageIgnore
            }

            foreach ($entities as $entity) {
                $this->entities->add($entity);
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
