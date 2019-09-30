# Symfony Messenger Integration

Symfony Messenger can be used to implement:

 * CommandBus
 * QueryBus
 * EventBus

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
                    - validation
                    - doctrine_transaction

            query.bus:
                middleware:
                    - validation

            event.bus:
                middleware:
                    - validation

        transports:
            # https://symfony.com/doc/current/messenger.html#transport-configuration
            domain_events:
                dsn: '%env(MESSENGER_TRANSPORT_DSN)%/domain_events'
                options:
                    exchange:
                        name: domain_events
                        type: fanout
                        durable: true
            # optional to capture failures
            failed: 'doctrine://default?queue_name=failed'
            # synchronous transport
            sync: 'sync://'

        routing:
            # Route your messages to the transports
            Somnambulist\Domain\Events\AbstractDomainEvent: domain_events
            Somnambulist\Domain\Commands\AbstractCommand: sync
            Somnambulist\Domain\Queries\AbstractQuery: sync
```

The above configuration will automatically route all extended Commands and Queries to the sync
transport and the DomainEvent instances to the event bus named `domain_events`.

Then the following services should be defined in `services.yaml`:

```yaml
services:
    Somnambulist\Domain\Events\Messenger\EventBus:
    
    Somnambulist\Domain\Events\EventBus:
        alias: Somnambulist\Domain\Events\Messenger\EventBus
        public: true
    
    Somnambulist\Domain\Commands\Messenger\CommandBus:
    
    Somnambulist\Domain\Commands\CommandBus:
        alias: Somnambulist\Domain\Commands\Messenger\CommandBus
        public: true
    
    Somnambulist\Domain\Queries\Messenger\QueryBus:
    
    Somnambulist\Domain\Queries\QueryBus:
        alias: Somnambulist\Domain\Queries\Messenger\QueryBus
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
