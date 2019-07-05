<?php

/**
 * Class EventListener
 */
class DomainEventListener
{

    public function onMyEntityCreated($event)
    {
        printf(
            "New item created with id: %s, name: %s, another: %s\n",
            $event->property('id'),
            $event->property('name'),
            $event->property('another')
        );
    }

    public function onMyEntityAddedAnotherEntity($event)
    {
        printf(
            "Added related entity with name: %s, another: %s to entity id: %s\n",
            $event->property('other')['name'],
            $event->property('other')['another'],
            $event->property('id')
        );
    }
}
