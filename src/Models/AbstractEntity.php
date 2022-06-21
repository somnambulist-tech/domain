<?php declare(strict_types=1);

namespace Somnambulist\Components\Models;

use Somnambulist\Components\Models\Contracts\CanTestEquality;
use function get_class;

/**
 * Represents a child entity within an aggregate root.
 *
 * A child entity does not exist beyond the scope of the aggregate root. If your
 * child entity needs to be accessed separately from the aggregate root, then it
 * is not a child entity, but instead a standalone entity and potentially another
 * aggregate root.
 *
 * Models have a continuous thread of identity through the domain. This identity
 * may be completely unique, or a compound key using part of the aggregate identity.
 * Models are composed of value objects and should implement business logic.
 *
 * This implementation expects the identity to be provided by the aggregate root that
 * owns it. During creation, both the aggregate and this identity should be provided.
 *
 * Note: in 5.0 the type definition will change to require an integer identity; it will
 * no longer allow for null. See `AbstractSurrogateEntity` for entities with nullable
 * identities.
 */
abstract class AbstractEntity implements CanTestEquality
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
