<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Support\Stubs\EventListeners;

use Somnambulist\Components\Domain\Events\AbstractEvent;
use Somnambulist\Components\Domain\Events\EventBus;

class DomainEventListener implements EventBus
{
    public function notify(AbstractEvent $event): void
    {
        $method = 'on' . $event->getName();

        $this->{$method}($event);
    }

    public function afterCurrent(AbstractEvent $event): void
    {
        $method = 'on' . $event->getName();

        $this->{$method}($event);
    }

    public function onMyEntityCreated(AbstractEvent $event)
    {
        printf(
            "New item created with id: %s, name: %s, another: %s\n",
            $event->payload()->get('id'),
            $event->payload()->get('name'),
            $event->payload()->get('another')
        );
    }

    public function onMyEntityAddedAnotherEntity(AbstractEvent $event)
    {
        printf(
            "Added related entity with name: %s, another: %s to entity id: %s\n",
            $event->payload()->get('other')['name'],
            $event->payload()->get('other')['another'],
            $event->payload()->get('id')
        );
    }
}
