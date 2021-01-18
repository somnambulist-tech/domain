# Somnambulist Domain Package

[![GitHub Actions Build Status](https://github.com/somnambulist-tech/domain/workflows/tests/badge.svg)](https://github.com/somnambulist-tech/domain/actions?query=workflow%3Atests)

Provides a core set of support classes for building domain oriented projects. This library compiles the
previously separate domain and mapping libraries into a single project for easier maintenance.

It consists of:
 
 * Commands
   * CommandBus interface / abstract command
   * SF Messenger implementation
 * Doctrine
   * Enumeration factories + Type bindings
   * Additional types / type overrides for the Doctrine Type system
   * Abstract EntityLocator that extends EntityRepository
   * Custom Postgres DQL functions
   * Custom traits for EntityRepository
 * Entities
   * Contracts - value object interface definitions
   * Types - a collection of value-objects, enumerations and an aggregate root
   * AggregateRoot - an aggregate root stub implementation that can raise events
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

 * PHP 7.4+
 * mb_string
 * bcmath
 * beberlei/assert
 * eloquent/enumeration
 * somnambulist/collection
 * symfony/messenger for the Messenger bus implementations.

### Installation

Install using composer, or checkout / pull the files from github.com.

 * composer require somnambulist/domain

### Upgrading from 3.X to 4.X

From 4.X this projects was re-namespaced to `Somnambulist\Components\Domain`. Update all references to
reflect this change this includes any Doctrine mapping files / annotations.

The Doctrine `AbstractIdentityType` was moved out of the `Identity` namespace to the main `Types`.

### Usage

See the docs folder for more documentation on each component.

 * [Aggregate Root](docs/aggregate-root.md)
 * [Enumeration Bridge](docs/doctrine-enum-bridge.md)
 * [Enumerations](docs/enumerations.md)
 * [Doctrine Mapping](docs/doctrine-mappings.md)
 * [Domain Events](docs/domain-events.md)
 * [Symfony Messenger Integration](docs/messenger.md)
 * [Value Objects](docs/value-objects.md)

### Links

 * [Doctrine](http://doctrine-project.org)
 * [Domain Input Mapper](https://github.com/dave-redfern/somnambulist-domain-input)
 * [Read-Models](https://github.com/dave-redfern/somnambulist-read-models)
 * [Collection](https://github.com/dave-redfern/somnambulist-collection)
