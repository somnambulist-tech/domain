Change Log
==========

2019-10-22
----------

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

2019-09-03
----------

 * Added EntityLocator abstract class
 * Added locator helper traits
 * Added some useful Postgres DQL functions
 * Added Pagerfanta paginator helper

2019-08-22
----------

 * Added some common types of exception for entity operations

2019-07-02
----------

Initial commit.

 * merges somnambulist/aggregate-root
 * merges somnambulist/domain-events
 * merges somnambulist/doctrine-enum-bridge
 * merges somnambulist/value-object-doctrine-mappings
 * merges somnambulist/value-objects

Together into a single package instead of being tiny individual packages that are cross-dependent.
