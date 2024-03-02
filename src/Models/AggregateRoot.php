<?php declare(strict_types=1);

namespace Somnambulist\Components\Models;

use Assert\Assertion;
use Assert\InvalidArgumentException;
use Somnambulist\Components\Events\AbstractEvent;
use Somnambulist\Components\Models\Contracts\CanTestEquality;
use Somnambulist\Components\Models\Types\DateTime\DateTime;
use Somnambulist\Components\Models\Types\Identity\AbstractIdentity as Identity;
use Somnambulist\Components\Models\Types\Identity\Aggregate;
use function is_a;
use function sprintf;

/**
 * An implementation of an Aggregate Root
 *
 * Provides an entry point / transaction boundary in a bounded context. The aggregate
 * root should contain the applications business logic relating to the context.
 * Aggregates should be the only component that raises events, delegating to entities,
 * and helpers, where necessary to ensure consistent state.
 *
 * When referring to other aggregates, only the identity should be referenced and not a
 * hard relationship. For more complex needs, create a value object abstraction to ensure
 * separation of contexts (anti-corruption layer).
 *
 * You must define your own constructor and ensure that this accepts whatever data is required
 * for the aggregate to be valid. For example:
 *
 * <code>
 * class User extends AggregateRoot
 * {
 *     private function __construct(Id $id, Name $name, EmailAddress $email)
 *     {
 *
 *     }
 * }
 * </code>
 *
 * Generally constructors should be private to enforce object creation through named factory
 * methods. This allows events to be generated only on actual creation and not potentially
 * via "new" instances.
 */
abstract class AggregateRoot implements CanTestEquality
{
    protected Identity $id;
    protected ?DateTime $createdAt = null;
    protected ?DateTime $updatedAt = null;
    private array $events = [];

    final public function id(): Identity
    {
        return $this->id;
    }

    final public function equals(object $object): bool
    {
        if (!$object instanceof AggregateRoot) {
            return false;
        }

        return $this->id->equals($object->id());
    }

    final public function raise(string $event, array $payload = [], array $context = []): void
    {
        if (!is_a($event, AbstractEvent::class, true)) {
            throw new InvalidArgumentException(
                sprintf('Provided event class name was not an %s', AbstractEvent::class),
                Assertion::INVALID_INSTANCE_OF
            );
        }

        $this->changeLastUpdatedToNow();
        $this->events[] = new $event($payload, $context, new Aggregate(static::class, (string)$this->id()));
    }

    final public function releaseAndResetEvents(): array
    {
        $pendingEvents = $this->events;

        $this->events = [];

        return $pendingEvents;
    }

    final protected function initializeTimestamps(): void
    {
        if ($this->createdAt && $this->updatedAt) {
            return;
        }

        $this->createdAt = DateTime::now();
        $this->updatedAt = DateTime::now();
    }

    final protected function changeLastUpdatedToNow(): void
    {
        $this->updatedAt = DateTime::now();
    }
}
