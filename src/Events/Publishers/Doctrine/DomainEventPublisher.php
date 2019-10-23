<?php declare(strict_types=1);

namespace Somnambulist\Domain\Events\Publishers\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Events;
use Somnambulist\Collection\MutableCollection as Collection;
use Somnambulist\Domain\Entities\Contracts\AggregateRoot;
use Somnambulist\Domain\Entities\Types\Identity\Aggregate;
use Somnambulist\Domain\Events\AbstractDomainEvent;
use Somnambulist\Domain\Events\Contracts\RaisesDomainEvents;
use Somnambulist\Domain\Events\EventBus;
use Somnambulist\Domain\Events\Publishers\Behaviours\BroadcastsDomainEvents;

/**
 * Class DomainEventListener
 *
 * Based on the Gist by B. Eberlei https://gist.github.com/beberlei/53cd6580d87b1f5cd9ca
 *
 * @package    Somnambulist\Domain\Events\Publishers\Doctrine\Subscribers
 * @subpackage Somnambulist\Domain\Events\Publishers\Doctrine\Subscribers\DomainEventPublisher
 */
class DomainEventPublisher implements EventSubscriber
{

    use BroadcastsDomainEvents;

    /**
     * @var Collection|RaisesDomainEvents[]
     */
    private $entities;

    /**
     * Constructor.
     *
     * @param EventBus|null $eventBus
     */
    public function __construct(EventBus $eventBus = null)
    {
        $this->entities = new Collection();
        $this->eventBus = $eventBus;
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [Events::prePersist, Events::preFlush, Events::postFlush];
    }

    public function prePersist(LifecycleEventArgs $event): void
    {
        $entity = $event->getEntity();

        if ($entity instanceof RaisesDomainEvents) {
            $this->entities->add($entity);
        }
    }

    public function preFlush(PreFlushEventArgs $event): void
    {
        $uow = $event->getEntityManager()->getUnitOfWork();

        foreach ($uow->getIdentityMap() as $class => $entities) {
            if (!in_array(RaisesDomainEvents::class, class_implements($class))) {
                continue; // @codeCoverageIgnore
            }

            foreach ($entities as $entity) {
                $this->entities->add($entity);
            }
        }
    }

    public function postFlush(PostFlushEventArgs $event): void
    {
        $em     = $event->getEntityManager();
        $evm    = $em->getEventManager();
        $events = $this->sortEventsForDispatch($event);

        /*
         * Events should now be in created order so they can be dispatched / published.
         * If overriding this subscriber, fire messages to rabbitmq, beanstalk etc here
         * or replace doctrine event manager with another event dispatcher.
         */
        $events->each(function ($event) use ($em, $evm) {
            /** @var AbstractDomainEvent $event */
            $evm->dispatchEvent('on' . $event->name(), EventProxy::createFrom($event));
            $this->notify($event);
            return true;
        });

        $this->clear();
    }

    protected function sortEventsForDispatch(PostFlushEventArgs $event): Collection
    {
        $em     = $event->getEntityManager();
        $events = new Collection();

        /*
         * Capture all domain events in this UoW and re-order for dispatch
         */
        foreach ($this->entities as $entity) {
            $class = $em->getClassMetadata(get_class($entity));
            $id    = $entity instanceof AggregateRoot ? $entity->id() : $class->getSingleIdReflectionProperty()->getValue($entity);

            foreach ($entity->releaseAndResetEvents() as $domainEvent) {
                /** @var AbstractDomainEvent $domainEvent */
                $domainEvent->setAggregate(new Aggregate($class->name, $id));

                $events->add($domainEvent);
            }
        }

        $events->sortUsing(function ($a, $b) {
            /** @var AbstractDomainEvent $a */
            /** @var AbstractDomainEvent $b */
            return bccomp((string)$a->time(), (string)$b->time(), 6);
        });

        return $events;
    }

    protected function clear(): void
    {
        $this->entities->clear();
    }
}
