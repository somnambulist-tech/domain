<?php declare(strict_types=1);

namespace Somnambulist\Domain\Events\Publishers;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Events;
use Somnambulist\Collection\MutableCollection;
use Somnambulist\Domain\Entities\AggregateRoot;
use Somnambulist\Domain\Events\AbstractEvent;
use Somnambulist\Domain\Events\EventBus;

/**
 * Class DomainEventListener
 *
 * Based on the Gist by B. Eberlei https://gist.github.com/beberlei/53cd6580d87b1f5cd9ca
 *
 * @package    Somnambulist\Domain\Events\Publishers\Doctrine\Subscribers
 * @subpackage Somnambulist\Domain\Events\Publishers\Doctrine\Subscribers\DomainEventPublisher
 */
class DoctrineEventPublisher implements EventSubscriber
{

    private EventBus $eventBus;
    private MutableCollection $entities;

    public function __construct(EventBus $eventBus)
    {
        $this->entities = new MutableCollection();
        $this->eventBus = $eventBus;
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
            ->sortEventsForDispatch()
            ->each(fn (AbstractEvent $event) => $this->eventBus->notify($event))
        ;

        $this->clear();
    }

    protected function sortEventsForDispatch(): MutableCollection
    {
        $events = new MutableCollection();

        $this
            ->entities
            ->each(fn (AggregateRoot $entity) => $events->append(...$entity->releaseAndResetEvents()))
        ;

        return $events->sort(fn (AbstractEvent $a, AbstractEvent $b) => bccomp((string)$a->getTime(), (string)$b->getTime(), 6));
    }

    protected function clear(): void
    {
        $this->entities = new MutableCollection();
    }
}
