## Domain Events for PHP Entities

Adds support for Domain Events to plain old PHP entities. This package is inspired by and based
on the Gist and blog posts by Benjamin Eberlei: 

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
in that you should remove setters and nullable constructor arguments. Instead you will
need to manage changes to you entity through specific methods, for example:

 * completeOrder()
 * updatePermissions()
 * revokePermissions()
 * publishStory()

Internally, after updating the entity state, call: `$this->raise(new NameOfEvent([]))`
and pass any specific parameters into the event that you want to make available to the
listener. This could be the old vs new or the entire entity reference, it is entirely
up to you.

```php
class SomeObject extends AggregateRoot
{
    public function __construct($id, $name, $another, $createdAt)
    {
        $this->id        = $id;
        $this->name      = $name;
        $this->another   = $another;
        $this->createdAt = $createdAt;
        
        $this->raise(new MyEntityCreatedEvent(['id' => $id, 'name' => $name, 'another' => $another]));
    }
}
```

Generally it is better to not raise events in the constructor but instead to use named
constructors for primary object creation:

```php
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
        $entity->raise(new MyEntityCreatedEvent(['id' => $id, 'name' => $name, 'another' => $another]));
        
        return $entity;
    }
}
```

### Defining an Event

To define your own event extend the AbstractDomainEvent object. That's basically it!

```php
class MyEntityCreatedEvent extends AbstractDomainEvent
{

}
```

You can create an intermediary to add base methods to your events e.g.: if you want
to broadcast through a message queue you may want the event to name itself:

```php
abstract class AppDomainEvent extends AbstractDomainEvent
{

    public function notificationName()
    {
        return sprintf('%s.%s', $this->group(), strtolower($this->name()));
    }

    public function group()
    {
        return 'app';
    }
}
```

And then extend it with the overrides you need:

```php
class MyEntityCreatedEvent extends AppDomainEvent
{

    public function group()
    {
        return 'some_object';
    }
}
```

### Firing Domain Events

Depending on your framework / library choice, several integrations are provided.

#### Doctrine Integration

This implementation includes a Doctrine subscriber that will listen for entities that
implement the RaisesDomainEvent interface and then ensures that `releaseAndResetEvents()`
is called.
 
 * __Note:__ it is not required to use the `DomainEventPublisher` subscriber. You can
   implement your own event dispatcher, use another dispatcher entirely (the frameworks)
   and then manually trigger the domain events by flushing the changes and then manually
   calling `releaseAndResetEvents` and dispatching the events.
   
   If you do this note that the aggregate root class and primary identifier (if used)
   will not be set automatically. You will need to update your code to set these if
   you intend to use them.

To use the included listener, add it to your list of event subscribers in the Doctrine
configuration. This is per entity manager.

 * __Note:__ to use listeners with domain events that rely on Doctrine repositories
   it is necessary to defer loading those subscribers until after Doctrine has been
   resolved.

DomainEvent instances are proxied through a Doctrine EventArgs compatible layer that
preserves the original event and name.

#### Symfony Integration

A basic Symfony EventDispatcher bridge is included. You can use this with the Symfony
framework to register objects that raise events and then trigger the publishing at any
time by calling `Symfony\DomainEventPublisher::dispatch()`. All registered entities
will have the domain events collected, ordered and dispatched via the main Symfony
EventDispatcher.

The domain events are proxied via a Symfony compatible EventProxy that allows the
event name to be automatically converted to a Symfony dot name (entity.created). This
preserves the original Event, name and properties.

To listen for the events, create a listener and register it with the main event
dispatcher for the events matching the dot notation.

#### Laravel Integration

Laravels EventDispatcher does not have a typed event meaning you don't need any special
translation of events. An integration is provided to make registering event emitting
objects, similar to the Symfony integration.

```php
class SomeServiceClass
{
    protected $publisher;
    
    public function __construct($publisher)
    {
        $this->publisher = $publisher;
    }

    public function doSomethingComplicated()
    {
        $object = new SomeDomainObject(); // or fetch from wherever
        $this->publisher->publishEventsFrom($object);
        
        $object->callSomeMethod();
        $object->callSomeOtherMethod();
        $object->doSomethingElse();
        
        $this->publisher->dispatch();
    }
}
```

This will order and dispatch the events via the standard Laravel Event Dispatcher.

To listen for the events, bind your listeners in the usual way for a Laravel project
however: be sure to use the `Event::class`.

#### Symfony / Laravel Automatic Dispatch

If using the standalone publisher, you can create an onTerminate middleware / kernel
listener that fires all domain events at the end of the request.

Remember that you will need to register the objects that will raise events before
hand.

### Creating a Domain Event Listener

Listeners can have their own dependencies (constructor is not defined), and are called
after the onFlush Unit of Work event. The listener can perform any post processing as
necessary, even triggering more events.

The listener should add methods that are named:

 * onNameOfTheEvent
 * without "event" suffixed
 * method will receive the Domain event instance
 * Domain event will have the class and id of the aggregate available

The example from the unit test:

```php
class EventListener
{    
    public function onMyEntityCreated(MyEntityCreatedEvent $event)
    {
        printf(
            "New item created with id: %s, name: %s, another: %s",
            $event->getProperty('id'),
            $event->getProperty('name'),
            $event->getProperty('another')
        );
    }
}
```

The unit test shows how it can be implemented.

Be sure to read the posts by Benjamin Eberlei mentioned earlier and check out his
[Assertion library](https://github.com/beberlei/assert) for low dependency entity
validation.
