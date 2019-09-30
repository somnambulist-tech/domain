## Aggregate Root

Implements a generalised Aggregate Root for raising domain events in an entity. 

 * [Doctrine and Domain Events](https://github.com/beberlei/whitewashing.de/blob/master/2013/07/24/doctrine_and_domainevents.rst)
 * [Decoupling applications with Domain Events](http://www.whitewashing.de/2012/08/25/decoupling_applications_with_domain_events.html)
 * [Gist for Doctrine Implementation](https://gist.github.com/beberlei/53cd6580d87b1f5cd9ca)

### Using

An Aggregate is a Domain Driven Design concept that encapsulates a set of related
domain concepts that should be managed together. See [Fowler: Aggregate Root](https://martinfowler.com/bliki/DDD_Aggregate.html)
Examples include: Order, User, Customer. In your domain code, only the aggregate
should be loaded.

First identify what you aggregate roots are within your domain objects. Then extend
the abstract AggregateRoot into your root entity. This is the entry point for changes
to that tree of objects.

Next: implement your domain logic and raise appropriate events for each of the changes
that your aggregate should allow / manage.

### Raising Events

To raise an event, decide which actions should result in a domain event. These should
coincide with state changes in the domain objects and the events should originate from
your main entities (aggregate roots).

For example: you may want to raise an event when a new User entity is created or that
a role was added to the user.

This does necessitate some changes to how you typically work with entities and Doctrine
in that you should remove setters and nullable constructor arguments. Instead you will
need to manage changes to your entity through specific methods, for example:

 * completeOrder()
 * updatePermissions()
 * revokePermissions()
 * publishStory()

Internally, after updating the entity state, call: `$this->raise(new NameOfEvent([]))`
and pass any specific parameters into the event that you want to make available to the
listener. This could be the old vs new or the entire entity reference, it is entirely
up to you.

```php
<?php
class MyAggregate extends AggregateRoot
{
    public function __construct($id, $name, $another)
    {
        $this->id        = $id;
        $this->name      = $name;
        $this->another   = $another;
        
        $this->>initializeTimestamps();
        
        $this->raise(new MyEntityCreatedEvent(['id' => $id, 'name' => $name, 'another' => $another]));
    }
}
```

Generally it is better to not raise events in the constructor but instead to use named
constructors for primary object creation:

```php
<?php
class MyAggregate extends AggregateRoot
{
    private function __construct($id, $name, $another)
    {
        $this->id        = $id;
        $this->name      = $name;
        $this->another   = $another;
        
        $this->>initializeTimestamps();
    }
    
    public static function create($id, $name, $another)
    {
        $entity = new static($id, $name, $another, new DateTime());
        $entity->raise(new MyEntityCreatedEvent(['id' => $id, 'name' => $name, 'another' => $another]));
        
        return $entity;
    }
}
```

### Dealing with Timestamps

When dealing with Aggregates, the aggregate should maintain its state; this includes any
timestamps. If these are deferred to the database or ORM layer, then your Aggregate is being
changed outside separately to when the state was changed.

Instead of relying on the ORM or database, you should use the `initializeTimestamps()` and
`updateTimestamps()` methods from the `Timestampable` trait, or implement similar logic yourself.
Then in your aggregate (and other entities), be sure to call `updatedTimestamps()` whenever a
change is made

### Dealing with Sub-Objects

When creating an aggregate root, it is tempting to place all functionality within the scope
of that single class, even though there may be child objects related to it. If those need to
be updated, then they should be the ones to do that update.

As the `raise()` method is public and the aggregate is passed to the child, you can use the
aggregate to raise more events from inside those child objects.

For example: an Order and an OrderItem, the quantity needs to be updated on the order item:

```php
$order->lineItem($ref)->changeQuantity(4);
```

The OrderItem method might be something like:

```php
<?php
class OrderItem
{

    public function changeQuantity(int $quantity): void
    {
        Assert::that($quantity, 'quantity')->gt(0)->lte(20);
        
        $previousQuantity = $this->quantity;
        $this->quantity = $quantity;
        
        $this->order->raise(new OrderItemQuantityChanged([
            'id' => $this->order->id(),
            'item_id' => $this->id(),
            'quantity' => $this->quantity,
        ], [
            'previous' => [
                'quantity' => $previousQuantity,
            ]
        ]));
    }
}
```

### Dealing with Collections

Similar to child objects, it is common to apply all the collection handling logic directly in
the main aggregate.

However: we want to avoid exposing the internals to modification so instead or allowing direct
access to the underlying collection instance, you can wrap it in a broker that can mediate
access to the entities it controls. This way events on delete can be triggered easily and
manipulations can be controlled.

For example: a User can have several addresses of certain types:

```php
<?php
class UserAddresses
{
     private $user;
     private $addresses;

     public function __construct(User $user, Collection $addresses)
     {
         // assign vars
     }
     
     public function for(AddressType $type)
     {
         if (!$addr = $this->addresses->get((string)$type)) {
            throw new DomainException('User does not have an address for type: ' . $type);
         }
         
         return $addr;
     }
}
```
Now to update the address it would be something like:
```php
$user->addresses()->for(AddressType::DELIVERY())->updateAddressTo(Address $address);
```
If the User does not have a delivery address, an exception would be raised. In this example
an Enumeration is used for the type to provide type safety and the Address is passed as a
value object, again, providing type safety.

### Firing Domain Events

See [Domain Events](domain-events.md) for integrating various strategies for dispatching
domain events raised from the aggregate root.

Be sure to read the posts by Benjamin Eberlei mentioned earlier and check out his
[Assertion library](https://github.com/beberlei/assert) for low dependency entity
validation.
