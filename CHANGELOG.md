Change Log
==========

2023-01-22
----------

 * Add `Paginatable` and `Sortable` as interfaces for queries
 * Move `UsesResponseClass` to `Queries\Contracts` with fallback alias

2023-01-12
----------

 * Add interface for queries to support response objects
 * Add metadata behaviour for queries for additional context information
 * Add and update documentation
 * Tweak and clean up various code inspection issues

2023-01-04
----------

 * Add support for query response objects in query bus

2022-09-26
----------

 * Generate event name at construction time
 * B/C: Make event name snake_case by default
 * Fix `EntityAccessor::extract` not pulling date object time/timezone values
 * Fix `ObjectDiff` not supporting date object comparison

2022-09-06
----------

 * Require PHP 8.1
 * Remove all deprecated classes and methods
 * Remove classmap
 * Remove more missed unnecessary docblocks
 * Add missing final to value objects
 * Add readonly to many properties where it can be
 * Make context readonly on AbstractEvent and modifications return a new instance, preserving time

2022-07-11 - 4.7.0
------------------

 * Fix locator aliases to work without doctrine
 * Fix additional aliases to work without messenger, serializer, etc.

2022-07-07
----------

 * Add `DateFormat` with all the various date formatting letters as constants
 * Add `DateFormatBuilder` for descriptively building date formats
 * Correct capitalisation of `IPv4Address` -> `IPV4Address`

2022-06-21
----------

 * Re-namespace to remove `Domain`, class aliases registered for BC
 * Remove many unnecessary class level docblock comments
 * Move `Entities` to `Models`, classes are aliased to preserve previous for BC
 * Add `AbstractSurrogateEntity` for entities with nullable identities
 * Add extra documentation in docblock headers in several model classes

2022-05-26 - 4.6.0
------------------

 * Add ISO 2 char and numeric codes to `Country`, updated country list from ISO

2022-05-13
----------

 * Add support for `$supportedEventPrefixes` to the event normalizer to handle cases where event
   is not defined in the project

2022-04-13
----------

 * Deprecate `with()` on `CanIncludeRelatedData`
 * Deprecate dynamic accessors on `AbstractPaginatableQuery`
 * Add `CanOrderQuery` alias for `CanSortQuery` trait
 * Add `include()` on `CanIncludeRelatedData` trait for better consistency
 * Add none `get` methods on `AbstractEvent` renaming several; deprecated original methods
 * Add none `get` methods on abstract query classes; deprecated original methods
 * Move `EventDecoratorInterface` to main `Events` namespace; alias remains for `Events\Decorators`
 * Clean language in changelog

2022-04-04 - 4.5.0
------------------

 * Re-implement domain event serialization to use a normalizer registered with SF Serializer
 * Deprecate `MessengerSerializer` as it is not correctly handling stamps
 * Update messenger integration docs

2022-04-01 - 4.4.0
------------------

 * Add `CanConvertValueToBoolean` trait for casting string values to booleans
 * Add more return types to address deprecation messages
 * Fix potential issue in enumeration handling when values are nullable
 * Clean up class code

2022-04-01 - 4.3.4
------------------

 * Fix bug in event deserialize; if event class exists and is an event it should use that

2021-12-14 - 4.3.3
------------------

 * Add more return types to address deprecation notices
 * Add phpunit-bridge to dev dependencies for better tracking deprecations

2021-12-14 - 4.3.2
------------------

 * Add return types to address deprecation notices

2021-12-14 - 4.3.1
------------------

 * Fix add `preRemove` handler to ensure removed aggregates are still tracked for events
 * Fix add checks to prevent double adding aggregate roots when collecting entities

2021-09-14 - 4.3.0
------------------

 * Add enhancements to `DateTime` and `TimeZone` objects (thanks to @jasonhofer)

2021-09-01 - 4.2.2
------------------

 * Fix issue with SF Messenger validation and `AbstractEvent::fromArray()` generating errors in validation

2021-08-03 - 4.2.1
------------------

 * Add `array` to the query `with()` docblock comment; add note about deprecated behaviour

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
 * Move `AbstractIdentityType` out of `Identity` namespace to `Types` namespace

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
 * Add `JobQueue` and `AbstractJob`
 * Add `Id` value-object and mapping files / type
 * Add `AbstractEntity` a child entity implementation
 * Add `AbstractEntityCollection` for managing child entities within the scope of an aggregate
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

 * Deprecate `QueryBus::query()` to `QueryBus::execute()`, query will be removed in 3.0
 
2020-03-19 - 2.4.3
------------------

 * Add ZZZ - Worldwide to the Country entity

2020-02-11 - 2.4.2
------------------

 * Fix `AbstractIdentity` can sometimes hydrate with a UUID object causing type error when using `toUuid()`

2020-02-03 - 2.4.1
------------------

 * Fix incorrect country code for Romania

2020-01-10 - 2.4.0
------------------

 * Add `Auth\Password` value object to entities

2019-11-19 - 2.3.0
------------------

 * Add `AbstractFindByIdQuery` to queries
 * Add `AbstractIdentity` to entities
 * Add `AbstractType` to entities
 * Made `Uuid` final and extend `AbstractIdentity`
 * Fix bugs in `AbstractPaginatableQuery` and added test case

2019-11-19 - 2.2.8
------------------

 * Change `AbstractDomainEvent::fromArray` to be able to create abstract events when
   the event class does not exist. For example: a queue consumer in a separate project.
   If the event class does exist it must still extend `AbstractDomainEvent`.

2019-11-19 - 2.2.7
------------------

 * Fix array not initialised in CanIncludeRelatedData trait

2019-10-29 - 2.2.5 / 2.2.6
--------------------------

 * Add test behaviour helpers for asserting on raised domain events

2019-10-28 - 2.2.4
------------------

 * Add some common query behaviours
 * Add a paginatable query
 
2019-10-25 - 2.2.3
------------------

 * Add IdentityGenerator for making Uuid objects from Ramsey UUID

2019-10-24 - 2.2.2
------------------

 * Add short aliases to class name - class names will be deprecated in 3.X

2019-10-24 - 2.2.1
------------------

 * Fix bug in EnumerationBridge not passing field declaration through

2019-10-22 - 2.2.0
------------------

 * Add toArray / toJson to domain event
 * Add fromArray to re-generate a domain event from an event payload
 * Add better documentation for using Doctrine event broadcaster
 * Add custom Messenger serializer for sending domain event objects
 * Change doctrine publisher to use aggregate id if the entity is an AggregateRoot

2019-10-21
----------

 * Add ExternalIdentity value object

2019-09-30
----------

 * Add an SF Messenger based Command, Event and Query bus

2019-09-03 - 2.1.0
------------------

 * Add EntityLocator abstract class
 * Add locator helper traits
 * Add some useful Postgres DQL functions
 * Add Pagerfanta paginator helper

2019-08-22 - 2.0.3
------------------

 * Add some common types of exception for entity operations

2019-07-13
----------

 * Add South Sudan
 * Fix bugs in namespaces / use statements

2019-07-11 - 2.0.0
------------------

 * Update to somnambulist/collection v3.0 - BC breaking change

2019-07-02 - 1.0.0
------------------

Initial commit.

 * merges somnambulist/aggregate-root
 * merges somnambulist/domain-events
 * merges somnambulist/doctrine-enum-bridge
 * merges somnambulist/value-object-doctrine-mappings
 * merges somnambulist/value-objects

Together into a single package instead of being tiny individual packages that are cross-dependent.
