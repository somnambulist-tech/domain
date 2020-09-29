<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities;

use Countable;
use Doctrine\Common\Collections\Collection;
use IteratorAggregate;

/**
 * Class AbstractEntityCollection
 *
 * Provides a wrapper for managing child entities outside of an aggregate root.
 * This allows logic to still be tied with the aggregate, but moved out to a sub-object
 * to keep the main aggregate logic smaller.
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

    public function __construct(AggregateRoot $root, Collection $entities)
    {
        $this->root     = $root;
        $this->entities = $entities;
    }

    public function getIterator()
    {
        return $this->entities;
    }

    public function count()
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
        if (0 === $this->count()) {
            return 1;
        }

        return (int)max($this->entities->map(fn (AbstractEntity $e) => $e->id())->getValues()) + 1;
    }
}
