<?php declare(strict_types=1);

namespace Somnambulist\Components\Models;

use Somnambulist\Components\Models\Contracts\CanTestEquality;
use function get_class;

/**
 * Represents a child entity within an aggregate root.
 *
 * Unlike `AbstractEntity` this implementation expects the identity to be provided
 * externally to the domain from the persistence store. An integer type is being
 * used to avoid performance issues between differing persistence stores.
 */
abstract class AbstractSurrogateEntity implements CanTestEquality
{
    protected ?int $id = null;
    protected AggregateRoot $root;

    public function id(): ?int
    {
        return $this->id;
    }

    public function equals(object $object): bool
    {
        if (get_class($this) !== get_class($object)) {
            return false;
        }

        return $this->id === $object->id && $this->root->equals($object->root);
    }

    public function __set($name, $value) {}

    public function __unset($name) {}
}
