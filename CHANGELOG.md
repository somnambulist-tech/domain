Change Log
==========

2021-04-28 - 4.2.0
------------------

 * Add `ObjectDiff` for comparing objects and returning an array of the differences by property, including arrays
 * Add `EntityAccessor::extract()` for getting all properties from an object (including private, parent properties)
 * Add `afterCurrent()` to `EventBus` and `CommandBus` to allow firing messages after the current has been handled

Note: the `extract` and `ObjectDiff` are considered experimental.

2021-02-04 - 4.1.0
------------------

 * Improve handling of EntityCollection helpers so that the identity during a request will always generate
   new identities.
 * Add trait for using collection helpers with aggregate root
 * Add docs for using collection helper / abstract entity

2021-01-25
----------

 * Fix spelling error

2021-01-21 - 4.0.0
------------------

 * Require PHP 8 to use Collection 5.0.0
 * Add additional type hints
 * Make use of exception catching without assignment

2021-01-18
----------

 * Fix PHP8 issues
 * Fix additional bugs
 * Update docs for release

Note: this was originally tagged as a 4.0.0 release, however it was retracted in favour of one that
uses `somnambulist/collection` 5.0.0+.

2020-12-18
----------

 * Fix DateTime factory `parse` method with optional arg before required
 * Clean up return types and method signatures based on code inspection results

2020-10-05
----------

 * Add ability to decorate events with contextual data via an `EventDecoratorInterface`
 * Add `DecorateWithRequestId` decorator to inject a request id into the event context
 * Add `DecorateWithUserData` decorator to add currently authenticated user data to the event context
 * Refactor internals of event publishers to make code re-usable

2020-10-03
----------

 * Add `AbstractValueObjectType` for making single value ValueObject types for Doctrine
 * Moved `AbstractIdentityType` out of `Identity` namespace to `Types` namespace

2020-09-29
----------

 * Re-namespace to `Somnambulist\Components`

2020-09-23 - 3.1.2
------------------

 * Relax type hint on `findByUuid()` to `AbstractIdentity` to allow other UUID classes

2020-09-22 - 3.1.1
------------------

 * Fix `TypedEnumerableConstructor` only working with strings, prevents int values

2020-09-21 - 3.1.0
------------------

 * Add `PasswordType` to Doctrine types and make default type

2020-08-28 - 3.0.0
------------------

 * Require PHP 7.4
 * Refactor Doctrine types
 * Refactor Events; removed AbstractDomainEvent in favour of AbstractEvent
 * Refactor AggregateRoot and event raising behaviour
 * Refactor Doctrine type UuidType to allow extending for other types easily
 * Remove all entity behaviours as aggregate roots should be focused on the business language
 * Remove additional event publishers; now only has messenger and doctrine
 * Remove `jsonb` and `json_collection` type aliases, use `json`
 * Remove class name aliases on enumerables; only short aliases are available by default
 * Added `JobQueue` and `AbstractJob`
 * Added `Id` value-object and mapping files / type
 * Added `AbstractEntity` a child entity implementation
 * Added `AbstractEntityCollection` for managing child entities within the scope of an aggregate
 * Rename EventBus `dispatch` to `notify`
 * Rename bus implementations to `Adapters` namespace and include `Messenger` in the class name
 * Rename enumerable constructors
 * `Country` and `Currency` now cast to ISO code not name
 * `Area` and `Distance` now cast with unit name as part of the string
 * `EntityAccessor` defaults the scope to the passed object, instead of `null`

2020-08-28 - 2.5.1
------------------

 * Deprecate EventBus::dispatch for notify

2020-08-28 - 2.5.0
------------------

 * Allow somnambulist/collection 4.X

2020-07-16 - 2.4.5
------------------

 * Allow ramsey/uuid 4.X (#6)

2020-03-19 - 2.4.4
------------------

 * Deprecated `QueryBus::query()` to `QueryBus::execute()`, query will be removed in 3.0
 
2020-03-19 - 2.4.3
------------------

 * Added ZZZ - Worldwide to the Country entity

2020-02-11 - 2.4.2
------------------

 * Fixed `AbstractIdentity` can sometimes hydrate with a UUID object causing type error when using `toUuid()`

2020-02-03 - 2.4.1
------------------

 * Fixed incorrect country code for Romania

2020-01-10 - 2.4.0
------------------

 * Added `Auth\Password` value object to entities

2019-11-19 - 2.3.0
------------------

 * Added `AbstractFindByIdQuery` to queries
 * Added `AbstractIdentity` to entities
 * Added `AbstractType` to entities
 * Made `Uuid` final and extend `AbstractIdentity`
 * Fixed bugs in `AbstractPaginatableQuery` and added test case

2019-11-19 - 2.2.8
------------------

 * Changed `AbstractDomainEvent::fromArray` to be able to create abstract events when
   the event class does not exist. For example: a queue consumer in a separate project.
   If the event class does exist it must still extend `AbstractDomainEvent`.

2019-11-19 - 2.2.7
------------------

 * Fix array not initialised in CanIncludeRelatedData trait

2019-10-29 - 2.2.5 / 2.2.6
--------------------------

 * Added test behaviour helpers for asserting on raised domain events

2019-10-28 - 2.2.4
------------------

 * Added some common query behaviours
 * Added a paginatable query
 
2019-10-25 - 2.2.3
------------------

 * Added IdentityGenerator for making Uuid objects from Ramsey UUID

2019-10-24 - 2.2.2
------------------

 * Added short aliases to class name - class names will be deprecated in 3.X

2019-10-24 - 2.2.1
------------------

 * Fixed bug in EnumerationBridge not passing field declaration through

2019-10-22 - 2.2.0
------------------

 * Added toArray / toJson to domain event
 * Added fromArray to re-generate a domain event from an event payload
 * Added better documentation for using Doctrine event broadcaster
 * Added custom Messenger serializer for sending domain event objects
 * Changed doctrine publisher to use aggregate id if the entity is an AggregateRoot

2019-10-21
----------

 * Added ExternalIdentity value object

2019-09-30
----------

 * Added an SF Messenger based Command, Event and Query bus based on

2019-09-03 - 2.1.0
------------------

 * Added EntityLocator abstract class
 * Added locator helper traits
 * Added some useful Postgres DQL functions
 * Added Pagerfanta paginator helper

2019-08-22 - 2.0.3
------------------

 * Added some common types of exception for entity operations

2019-07-13
----------

 * Added South Sudan
 * Fixed bugs in namespaces / use statements

2019-07-11 - 2.0.0
------------------

 * Updated to somnambulist/collection v3.0 - BC breaking change

2019-07-02 - 1.0.0
------------------

Initial commit.

 * merges somnambulist/aggregate-root
 * merges somnambulist/domain-events
 * merges somnambulist/doctrine-enum-bridge
 * merges somnambulist/value-object-doctrine-mappings
 * merges somnambulist/value-objects

Together into a single package instead of being tiny individual packages that are cross-dependent.
