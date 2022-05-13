# Symfony Messenger Integration

Symfony Messenger can be used to implement:

* CommandBus
* QueryBus
* EventBus
* JobQueue

These implementations are based on the Symfony documentation:

* https://symfony.com/doc/current/messenger/handler_results.html
* https://symfony.com/doc/current/messenger/multiple_buses.html

This requires setting up messenger as follows:

```yaml
framework:
    messenger:
        failure_transport: failed
        default_bus: command.bus

        buses:
            # creates a MessageBusInterface instance available on the $commandBus argument
            command.bus:
                middleware:
                    - doctrine_transaction

            query.bus:
                middleware:

            event.bus:
                middleware:

            job.queue:
                middleware:

        transports:
            # https://symfony.com/doc/current/messenger.html#transport-configuration
            domain_events:
                dsn: '%env(MESSENGER_TRANSPORT_DSN)%/domain_events'
                options:
                    exchange:
                        name: domain_events
                        type: fanout
            job_queue:
                dsn: '%env(MESSENGER_TRANSPORT_DSN)%/jobs'
                options:
                    exchange:
                        name: jobs
                        type: fanout
            # optional to capture failures
            failed: 'doctrine://default?queue_name=failed'
            # synchronous transport
            sync: 'sync://'

        routing:
            # Route your messages to the transports
            Somnambulist\Components\Domain\Events\AbstractEvent: domain_events
            Somnambulist\Components\Domain\Jobs\AbstractJob: job_queue
            Somnambulist\Components\Domain\Commands\AbstractCommand: sync
            Somnambulist\Components\Domain\Queries\AbstractQuery: sync
```

The above configuration will automatically route all extended Commands and Queries to the sync
transport and the DomainEvent instances to the event bus named `domain_events`. Jobs will go to
the `job_queue`.

Then the following services should be defined in `services.yaml`:

```yaml
services:
    Somnambulist\Components\Domain\Events\Adapters\MessengerEventBus:

    Somnambulist\Components\Domain\Events\EventBus:
        alias: Somnambulist\Components\Domain\Events\Adapters\MessengerEventBus
        public: true

    Somnambulist\Components\Domain\Jobs\Adapters\MessengerJobQueue:

    Somnambulist\Components\Domain\Jobs\JobQueue:
        alias: Somnambulist\Components\Domain\Jobs\Adapters\MessengerJobQueue
        public: true

    Somnambulist\Components\Domain\Commands\Adapters\MessengerCommandBus:

    Somnambulist\Components\Domain\Commands\CommandBus:
        alias: Somnambulist\Components\Domain\Commands\Adapters\MessengerCommandBus
        public: true

    Somnambulist\Components\Domain\Queries\Adapters\MessengerQueryBus:

    Somnambulist\Components\Domain\Queries\QueryBus:
        alias: Somnambulist\Components\Domain\Queries\Adapters\MessengerQueryBus
        public: true
```

To use the underlying Messenger instances, type-hint a `MessageBusInterface` and then use
the appropriate camelCased variable name:

```php
<?php
use Symfony\Component\Messenger\MessageBusInterface;

class MyController extends Controller
{
    public function __construct(MessageBusInterface $commandBus)
    {
        // the command bus Messenger instance will be injected
        $this->commandBus = $commandBus;
    }
}
```

Now the services can be type-hinted using the interfaces and auto-wired correctly.

The `EventBus` can be injected into the Doctrine subscriber to allow for the domain events
to be automatically broadcast postFlush.

### Broadcast Domain Events

The Doctrine event subscriber supports broadcasting domain events if the EventBus is configured.
To enable the event subscriber add the following to your `services.yaml`:

```yaml
services:
    Somnambulist\Components\Domain\Events\Publishers\DoctrineEventPublisher:
        tags: [ 'doctrine.event_subscriber' ]
```

This will register a Doctrine event subscriber that listens to:

* prePersist
* preRemove
* preFlush
* postFlush

Events are queued, sorted by the timestamp to ensure the correct order and sent postFlush.

__Note:__ Messenger 4.3+ defaults to PHP native serializer. This will mean that the
message payload contains PHP serialized objects. To send JSON payloads, a custom serializer is
needed. This must be configured as follows:

__Note:__ as of v4.5.0 the `MessengerSerializer` implementation has been deprecated, and should
not be used. If you are currently using this, replace with the normalizer outlined below.

Install Symfony Serializer if not already installed: `composer req symfony/serializer symfony/property-access`.

__Note:__ `property-access` is required to enable the `ObjectNormalizer` that is used to
serialize the envelope stamp objects.

Add the following service to your `services.yaml` or another service file:

```yaml
services:
    Somnambulist\Components\Domain\Events\Adapters\DomainEventNormalizer:
        tags: [ 'serializer.normalizer' ]
```

The `tags` are only required if autoconfigure is set to `false`.

This will register a custom (de)normalizer with the Symfony Serializer that can properly handle
the structure of the domain events.

The `DomainEventNormalizer` will handle any events that are instances of `AbstractEvent` or that
start with one of a set of class name prefixes. These are needed when you are receiving events
from other services that are not defined but should still be handled. They are configured by passing
an array of strings in the service definition:

```yaml
services:
    Somnambulist\Components\Domain\Events\Adapters\DomainEventNormalizer:
        tags: [ 'serializer.normalizer' ]
        arguments:
            $supportedEventPrefixes: [ 'App\Domain\Events\', 'Service\Context\Domain\Events' ]
```

__Note:__ any event mentioned should follow the structure exported by `AbstractEvent::toArray`.
```json
{
    "aggregate": {
        "class": null,
        "id": null
    },
    "event": {
        "class": "The\\Event\\Class\\That\\Was\\Fired",
        "group": "app",
        "name": "fired",
        "time": 1652475367.784834
    },
    "payload": {
        "foo": "bar"
    },
    "context": {
        "context": "value",
        "user": "user@example.example"
    }
}
```

Next be sure to enable the default serializer, and configure it to always use JSON format:
(See: https://symfony.com/doc/current/messenger.html#serializing-messages for documentation)

```yaml
framework:
    messenger:
        serializer:
            default_serializer: messenger.transport.symfony_serializer
            symfony_serializer:
                format: json
                context: { }
```

__Note:__ the `EventBus` provided here is specifically for domain events. For general events
consider adding a separate bus.

__Note:__ since v3 the EventBus can handle generic events - they will not have an aggregate
associated with them but must still extend `AbstractEvent`.
