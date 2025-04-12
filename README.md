# Somnambulist Domain Package
[![GitHub Actions Build Status](https://img.shields.io/github/actions/workflow/status/somnambulist-tech/domain/tests.yml?logo=github&branch=master)](https://github.com/somnambulist-tech/domain/actions?query=workflow%3Atests)
[![Issues](https://img.shields.io/github/issues/somnambulist-tech/domain?logo=github)](https://github.com/somnambulist-tech/domain/issues)
[![License](https://img.shields.io/github/license/somnambulist-tech/domain?logo=github)](https://github.com/somnambulist-tech/domain/blob/master/LICENSE)
[![PHP Version](https://img.shields.io/packagist/php-v/somnambulist/domain?logo=php&logoColor=white)](https://packagist.org/packages/somnambulist/domain)
[![Current Version](https://img.shields.io/packagist/v/somnambulist/domain?logo=packagist&logoColor=white)](https://packagist.org/packages/somnambulist/domain)

Provides a core set of support classes for building domain oriented projects. This library compiles the
previously separate domain and mapping libraries into a single project for easier maintenance.

It consists of:
 
 * Commands
   * CommandBus interface / abstract command
   * SF Messenger implementation
 * Doctrine
   * Enumeration factories + Type bindings
   * Additional types / type overrides for the Doctrine Type system
   * Abstract Aggregate repository
   * Custom Postgres DQL functions
 * Models
   * Contracts - value object interface definitions
   * Types - a collection of value-objects, enumerations, and date helpers
   * AggregateRoot - an aggregate root stub implementation that can raise events
   * AbstractEntity and AbstractEntityCollection - child entities and helper for an aggregate root
 * Events
   * EventBus interface / abstract event
   * SF Messenger EventBus implementation
   * Doctrine subscriber that broadcasts onFlush all events from aggregate roots
   * Custom serializer to handle encode/decode when the event class does not exist
 * Jobs
   * JobQueue interface / abstract job
   * SF Messenger implementation 
 * Queries
   * QueryBus interface / abstract query
   * SF Messenger implementation 
 * default XML mappings for embeddable objects in Doctrine .dcm.xml and Symfony .orm.xml conventions

### Requirements

 * PHP 8.3+
 * mb_string
 * bcmath
 * beberlei/assert
 * eloquent/enumeration
 * somnambulist/collection
 * symfony/messenger for the Messenger bus implementations.

### Installation

Install using composer, or checkout / pull the files from github.com.

 * composer require somnambulist/domain

### Upgrading from 5.X to 6.X

From 6.0 PHP 8.3+ is required, additionally, with the move to Doctrine 3.0 there are substantial differences in how
repositories are implemented. Instead of using custom repositories, an `AbstractAggregateRepository` has been added
that directly calls into Doctrine EntityManager.

`AbstractModelLocator` and `AbstractServiceModelLocator` have been removed as the addition of type-hints prevented the
overriding of findBy etc. As these were helpers, they are no longer necessary.

Most model types are now read-only. Several have been changed to native enums (`DistanceUnit`, `AreaUnit`).

Commands and Jobs are now read-only classes. Queries are still writable to keep the meta-data and include support.

### Upgrading from 4.X to 5.X

From 5.X this project will be re-namespaced to drop `Domain`. 4.X includes a `classmap.php` providing
aliases for backwards compatibility.

From 5.0 the QueryBus supports typed response objects. This is an optional feature that provides a built-in 
mechanism to handle failed queries without trapping exceptions in the calling code.

From 5.0 domain event names are always generated at construction time as `snake_case`.

### Upgrading from 3.X to 4.X

From 4.X this project was re-namespaced to `Somnambulist\Components\Domain`. Update all references to
reflect this change this includes any Doctrine mapping files / annotations.

The Doctrine `AbstractIdentityType` was moved out of the `Identity` namespace to the main `Types`.

### Usage

See the docs folder for more documentation on each component.

 * [Aggregate Root](docs/aggregate-root.md)
 * [Domain Events](docs/domain-events.md)
 * [Value Objects](docs/value-objects.md)
 * [Enumerations](docs/enumerations.md)
 * [Enumeration Bridge](docs/doctrine-enum-bridge.md)
 * [Doctrine Mapping](docs/doctrine-mappings.md)
 * [Symfony Messenger Integration](docs/messenger.md)
 * [Using Command Query Separation](docs/cqrs.md)

### Links

 * [Doctrine](http://doctrine-project.org)
 * [API Bundle](https://github.com/somnambulist-tech/api-bundle)
 * [API Client](https://github.com/somnambulist-tech/api-client)
 * [Collection](https://github.com/somnambulist-tech/collection)
 * [Form Requests](https://github.com/somnambulist-tech/form-request-bundle)
 * [Read-Models](https://github.com/somnambulist-tech/read-models)
