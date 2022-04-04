## Domain Events

Domain events are part of the main AggregateRoot class. Extend this to be able to
raise events in your entity.

 * [Doctrine and Domain Events](https://github.com/beberlei/whitewashing.de/blob/master/2013/07/24/doctrine_and_domainevents.rst)
 * [Decoupling applications with Domain Events](http://www.whitewashing.de/2012/08/25/decoupling_applications_with_domain_events.html)
 * [Gist for Doctrine Implementation](https://gist.github.com/beberlei/53cd6580d87b1f5cd9ca)

### Raising Events

To raise an event, decide which actions should result in a domain event. These should
coincide with state changes in the domain objects and the events should originate from
your main entities (aggregate roots).

For example: you may want to raise an event when a new User entity is created or that
a role was added to the user.

This does necessitate some changes to how you typically work with entities and Doctrine
in that you should remove setters and nullable constructor arguments; instead you will
need to manage changes to your entity through specific methods, for example:

 * completeOrder()
 * updatePermissions()
 * revokePermissions()
 * publishStory()

Internally, after updating the entity state, call: `$this->raise(NameOfEvent::class, [])`
and pass any specific parameters into the event that you want to make available to the
listener. This could be the old vs new or the entire entity reference, it is entirely
up to you.

```php
<?php
use Somnambulist\Components\Domain\Entities\AggregateRoot;

class SomeObject extends AggregateRoot
{
    public function __construct($id, $name, $another, $createdAt)
    {
        $this->id        = $id;
        $this->name      = $name;
        $this->another   = $another;
        $this->createdAt = $createdAt;
        
        $this->raise(MyEntityCreatedEvent::class, ['id' => $id, 'name' => $name, 'another' => $another]);
    }
}
```

Generally it is better to not raise events in the constructor but instead to use named
constructors for primary object creation:

```php
<?php
use Somnambulist\Components\Domain\Entities\AggregateRoot;

class SomeObject extends AggregateRoot
{
    private function __construct($id, $name, $another, $createdAt)
    {
        $this->id        = $id;
        $this->name      = $name;
        $this->another   = $another;
        $this->createdAt = $createdAt;
    }
    
    public static function create($id, $name, $another)
    {
        $entity = new static($id, $name, $another, new DateTime());
        $entity->raise(MyEntityCreatedEvent::class, ['id' => $id, 'name' => $name, 'another' => $another]);
        
        return $entity;
    }
}
```

### Defining an Event

To define your own event extend the AbstractDomainEvent object. That's basically it!

```php
<?php
use Somnambulist\Components\Domain\Events\AbstractEvent;

class MyEntityCreatedEvent extends AbstractEvent
{

}
```

You can create an intermediary to add base methods to your events e.g.: if you want
to broadcast through a message queue you may want the event to name itself:

```php
<?php
use Somnambulist\Components\Domain\Events\AbstractEvent;

abstract class AppDomainEvent extends AbstractEvent
{

    protected string $group = 'app';

    public function getEventName(): string
    {
        return sprintf('%s.%s', $this->getGroup(), strtolower($this->getName()));
    }
}
```

And then extend it with the overrides you need:

```php
<?php
class MyEntityCreatedEvent extends AppDomainEvent
{

}
```

### Notifying Domain Events

#### Doctrine Integration

This implementation includes a Doctrine subscriber that will listen for AggregateRoots.
These are collected and once the Unit of Work has been flushed successfully will be
dispatched via the EventBus implementation that is in use (default Messenger).
 
 * __Note:__ it is not required to use the `DomainEventPublisher` subscriber. You can
   implement your own event dispatcher, use another dispatcher entirely (the frameworks)
   and then manually trigger the domain events by flushing the changes and then manually
   calling `releaseAndResetEvents` and dispatching the events.

To use the included listener, add it to your list of event subscribers in the Doctrine
configuration. This is per entity manager.

 * __Note:__ to use listeners with domain events that rely on Doctrine repositories
   it is necessary to defer loading those subscribers until after Doctrine has been
   resolved.

As of v3 the events are only broadcast on the event bus and are not sent to Doctrines
event manager.

#### Messenger Integration

This dispatcher allows you to register aggregates roots with the dispatcher, and then 
once you have finished manipulating the domain; notify all event changes to the bound
event bus (default Messenger).

This dispatcher uses an abstract base that includes methods for sorting and collecting
the events. It can be extended to perform other tasks.

This dispatcher can be registered with the `kernel.terminate` event so that any collected
events are fired at the end of the current request.

Remember: you will need to register the objects that will raise events.

__Note:__ the Messenger dispatcher does not release monitored aggregates after event
dispatch. You will need to specifically stop listening for events to clear the listener.

Be sure to read the posts by Benjamin Eberlei mentioned earlier and check out his
[Assertion library](https://github.com/beberlei/assert) for low dependency entity
validation.
