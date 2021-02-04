<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities;

use Countable;
use Doctrine\Common\Collections\Collection;
use IteratorAggregate;
use Traversable;
use function max;

/**
 * Class AbstractEntityCollection
 *
 * Provides a wrapper for managing child entities outside of an aggregate root.
 * This allows logic to still be tied with the aggregate, but moved out to a sub-object
 * to keep the main aggregate logic smaller.
 *
 * This class is intended to be used with the AbstractEntity class that uses integers for
 * the object identities. If you require a different scheme e.g.: some custom string then
 * implement your own base logic for those use-cases.
 *
 * When implementing be sure to add additional methods as necessary to provide the domain
 * implementations that are needed.
 *
 * @package    Somnambulist\Components\Domain\Entities
 * @subpackage Somnambulist\Components\Domain\Entities\AbstractEntityCollection
 */
abstract class AbstractEntityCollection implements Countable, IteratorAggregate
{

    protected AggregateRoot $root;
    protected Collection $entities;
    protected int $lastId;

    public function __construct(AggregateRoot $root, Collection $entities)
    {
        $this->root     = $root;
        $this->entities = $entities;
        $this->lastId   = $this->findLastId();
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

    protected function findById(int $id): ?AbstractEntity
    {
        return $this->entities->filter(fn (AbstractEntity $entity) => $entity->id() === $id)->first() ?: null;
    }

    protected function nextId(): int
    {
        return ++$this->lastId;
    }

    protected function findLastId(): int
    {
        return $this->count() > 0 ? (int)max($this->entities->map(fn (AbstractEntity $e) => $e->id())->getValues()) : 0;
    }
}
