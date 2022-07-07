## Aggregate Root

Implements a generalised Aggregate Root for raising domain events in an entity. 

 * [Doctrine and Domain Events](https://github.com/beberlei/whitewashing.de/blob/master/2013/07/24/doctrine_and_domainevents.rst)
 * [Decoupling applications with Domain Events](http://www.whitewashing.de/2012/08/25/decoupling_applications_with_domain_events.html)
 * [Gist for Doctrine Implementation](https://gist.github.com/beberlei/53cd6580d87b1f5cd9ca)

### BC Breaks v3

v3 of the Domain library radically overhauls how the base AggregateRoot is implemented
and removes all the previous interfaces and traits in-favour of a more tightly defined
root class.

Now the primary id is always a UUID but is now of type `AbstractIdentity` so that you
can use a class specific UUID identity e.g. UserId, or the general Uuid/Id if per 
aggregate identities are undesirable.

`createdAt` and `updatedAt` are now defined along with the methods to initialise
and update the updatedAt.

`raise()` now expects the event class name first and the aggregate identity will be
automatically inserted immediately on event creation.

### Using

An Aggregate is a Domain Driven Design concept that encapsulates a set of related
domain concepts that should be managed together. See [Fowler: Aggregate Root](https://martinfowler.com/bliki/DDD_Aggregate.html)
Examples include: Order, User, Customer. In your domain code, only the aggregate
should be loaded.

First identify what your aggregate roots are within your domain objects. Then extend
the abstract AggregateRoot into your root entity. This is the entry point for changes
to that tree of objects.

Next: implement your domain logic and raise appropriate events for each of the changes
that your aggregate should allow / manage. Your events should mirror business process
and ideally all your methods and objects should follow the businesses terminology.

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
 * grantPermissions()
 * revokePermissions()
 * publishStory()

Internally, after updating the entity state, call: `$this->raise(NameOfEvent::class, [])`
and pass any specific parameters into the event that you want to make available to the
listener. This could be the old vs new or the entire entity reference, it is entirely
up to you.

```php
<?php
use Somnambulist\Components\Models\AggregateRoot;

class MyAggregate extends AggregateRoot
{
    public function __construct($id, $name, $another)
    {
        $this->id        = $id;
        $this->name      = $name;
        $this->another   = $another;
        
        $this->initializeTimestamps();
        
        $this->raise(MyEntityCreatedEvent::class, ['id' => $id, 'name' => $name, 'another' => $another]);
    }
}
```

Generally it is better to not raise events in the constructor but instead to use named
constructors for primary object creation:

```php
<?php
use Somnambulist\Components\Models\AggregateRoot;

class MyAggregate extends AggregateRoot
{
    private function __construct($id, $name, $another)
    {
        $this->id        = $id;
        $this->name      = $name;
        $this->another   = $another;
        
        $this->initializeTimestamps();
    }
    
    public static function create($id, $name, $another)
    {
        $entity = new static($id, $name, $another, new DateTime());
        $entity->raise(MyEntityCreatedEvent::class, ['id' => $id, 'name' => $name, 'another' => $another]);
        
        return $entity;
    }
}
```

### Dealing with Timestamps

When dealing with Aggregates, the aggregate should maintain its state; this includes any
timestamps. If these are deferred to the database or ORM layer, then your Aggregate is being
changed outside separately to when the state was changed.

Instead of relying on the ORM or database, you should use the `initializeTimestamps()` and
`updateTimestamps()` methods that are part of the AggregateRoot class. The `updatedAt` property
is automatically updated when you raise an event (just before adding the event to the stack).

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
        
        $this->order->raise(OrderItemQuantityChanged::class, [
            'id' => $this->order->id(),
            'item_id' => $this->id(),
            'quantity' => $this->quantity,
        ], [
            'previous' => [
                'quantity' => $previousQuantity,
            ]
        ]);
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
     
    public function add(AddressType $type, AddressInfo $info): UserAddress
    {
        $this->entities->set((string)$type, $ua = new UserAddress($this->user, $type, $info));
        
        return $ua;
    }
}
```
Now to update the address it would be something like:
```php
$user->addresses()->for(AddressType::DELIVERY())->updateAddressTo($address);
```
If the User does not have a delivery address, an exception would be raised. In this example
an Enumeration is used for the type to provide type safety and the Address is passed as a
value object, again, providing type safety.

#### Built-in Entity Collection Helper / AbstractEntity

Alternatively the `AbstractEntityCollection` class can be used to provide suitable defaults
that you can extend to add your domain logic.

To use this, your child entities should extend the `AbstractEntity` class. This is required to
be able to use the `AbstractEntityCollection`. Note that these classes are set up to use basic
integers as the identity of the child object. If you require something more sophisticated, you
would need to implement your own alternative.

Using the same example as above this would be implemented as:

```php
<?php
use Somnambulist\Components\Models\AbstractEntityCollection;

class UserAddresses extends AbstractEntityCollection
{
    public function for(AddressType $type)
    {
        if (!$addr = $this->addresses->get((string)$type)) {
            throw new DomainException('User does not have an address for type: ' . $type);
        }
         
        return $addr;
    }
     
    public function add(AddressType $type, AddressInfo $info): UserAddress
    {
        $this->entities->set((string)$type, $ua = new UserAddress($this->root, $this->nextId(), $type, $info));
        
        $this->raise(AddressAddedToUser::class, [
            // add payload info
        ]);
        
        return $ua;
    }
}
```

On the AggregateRoot the method to load the helper changes slightly:

```php
use Somnambulist\Components\Models\AggregateRoot;
use Somnambulist\Components\Models\Behaviours\AggregateEntityCollectionHelper;

class User extends AggregateRoot
{
    use AggregateEntityCollectionHelper;

    public function addresses(): UserAddresses
    {
        return $this->collectionHelperFor($this->addresses, UserAddresses::class);
    }
}
```

The helper will be instantiated if it is not already set and then the same instance will be
returned each time. Only `AbstractEntityCollection` instances can be used with this trait.

To map this to Doctrine the following should be used on the child mapping definition:

```xml
<doctrine-mapping>
    <entity name="UserAddress" table="user_address">
        <id name="root" association-key="true" />
        <id name="id" type="integer" />

        <many-to-one field="root" target-entity="User" inversed-by="addresses">
            <cascade>
                <cascade-persist/>
            </cascade>
            <join-column name="user_id" />
        </many-to-one>
    </entity>
</doctrine-mapping>
```

The important part is the change to the `id` field: there are now 2, with the first having the
attribute `association-key`. This tells Doctrine to use the identity from the linked object,
in this case the AggregateRoot (that is held in the `root` property on the AbstractEntity class).
The second field tells Doctrine that the `id` property is also part of the identity. In effect
the actual identity of our child entity is now <aggregate_id> + <child_id> and is a compound key.

For database provided identities (surrogate identities), `AbstractSurrogateEntity` and 
`AbstractSurrogateEntityCollection` can be used as bases instead. Note that both of these
implementations are intended to be used with integer keys. For other types of identity key, use
your own logic.

Additionally: it is strongly discouraged to use an abstract entity type in your domain as it
encourages pushing logic down that is context specific. Generally it is better to duplicate the
logic per context to avoid future issues should a specific contexts usage change.

### Firing Domain Events

See [Domain Events](domain-events.md) for integrating various strategies for dispatching
domain events raised from the aggregate root.

Be sure to read the posts by Benjamin Eberlei mentioned earlier and check out his
[Assertion library](https://github.com/beberlei/assert) for low dependency entity
validation.
