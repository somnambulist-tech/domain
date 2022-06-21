<?php declare(strict_types=1);

namespace Somnambulist\Components\Models;

use Countable;
use Doctrine\Common\Collections\Collection;
use IteratorAggregate;
use Traversable;

/**
 * Provides a wrapper for managing child entities outside an aggregate root.
 * This allows logic to still be tied with the aggregate, but moved out to a sub-object
 * to keep the main aggregate logic smaller.
 *
 * Unlike `AbstractEntityCollection`, this helper class expects child entities to receive
 * an id from another source e.g. persistence layer. Use this as a base when you rely on
 * database provided (auto-increment / sequence) identities.
 */
class AbstractSurrogateEntityCollection implements Countable, IteratorAggregate
{
    public function __construct(protected AggregateRoot $root, protected Collection $entities)
    {
    }

    public function getIterator(): Traversable
    {
        return $this->entities;
    }

    public function count(): int
    {
        return $this->entities->count();
    }

    protected function raise(string $event, array $payload = [], array $context = []): void
    {
        $this->root->raise($event, $payload, $context);
    }

    protected function entities(): Collection
    {
        return $this->entities;
    }
}
