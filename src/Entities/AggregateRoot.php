<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities;

use Assert\Assertion;
use Assert\InvalidArgumentException;
use Somnambulist\Domain\Entities\Contracts\CanTestEquality;
use Somnambulist\Domain\Entities\Types\DateTime\DateTime;
use Somnambulist\Domain\Entities\Types\Identity\AbstractIdentity as Identity;
use Somnambulist\Domain\Entities\Types\Identity\Aggregate;
use Somnambulist\Domain\Events\AbstractEvent;
use function is_a;
use function sprintf;

/**
 * Class AggregateRoot
 *
 * @package    Somnambulist\Domain\Entities
 * @subpackage Somnambulist\Domain\Entities\AggregateRoot
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
        if (!is_a($event, AbstractEvent::class, $allowString = true)) {
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
