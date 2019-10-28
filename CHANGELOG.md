Change Log
==========

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
