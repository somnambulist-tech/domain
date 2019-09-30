# Somnambulist Domain Package

Provides a core set of support classes for building domain oriented projects. This library compiles the
previously separate domain and mapping libraries into a single project for easier maintenance.

It consists of:
 
 * Commands
   * CommandBus interface / abstract command
   * SF Messenger implementation
 * Entities
   * Behaviours - some default implementations for the interfaces
   * Contracts - some common interface definitions
   * Types - a collection of value-objects, enumerations and an aggregate root
 * Events
   * A domain events implementation including bindings for Doctrine, Symfony and Laravel
   * EventBus interface
   * SF Messenger EventBus implementation
   * Doctrine subscriber can additionally broadcast domain events using EventBus
 * Doctrine
   * Enumeration factories + Type bindings
   * Additional types / type overrides for the Doctrine Type system
   * Abstract EntityLocator that extends EntityRepository
   * Custom Postgres DQL functions
   * Custom traits for EntityRepository
 * Queries
   * QueryBus interface / abstract query
   * SF Messenger implementation 
 * default XML mappings for embeddable objects in Doctrine .dcm.xml and Symfony .orm.xml conventions

### Requirements

 * PHP 7.2+
 * mb_string
 * beberlei/assert
 * eloquent/enumeration
 * somnambulist/collection
 * symfony/messenger is required for the Messenger bus implementations.

### Installation

Install using composer, or checkout / pull the files from github.com.

 * composer require somnambulist/domain

### Usage

See the docs folder for more documentation on each component.

 * [Aggregate Root](docs/aggregate-root.md)
 * [Enumeration Bridge](docs/doctrine-enum-bridge.md)
 * [Enumerations](docs/enumerations.md)
 * [Doctrine Mapping](docs/doctrine-mappings.md)
 * [Domain Events](docs/domain-events.md)
 * [Entity Behaviours](docs/entity-behaviours.md)
 * [Symfony Messenger Integration](docs/messenger.md)
 * [Value Objects](docs/value-objects.md)

### Links

 * [Doctrine](http://doctrine-project.org)
 * [Domain Input Mapper](https://github.com/dave-redfern/somnambulist-domain-input)
 * [Read-Models](https://github.com/dave-redfern/somnambulist-read-models)
 * [Collection](https://github.com/dave-redfern/somnambulist-collection)
