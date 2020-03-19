<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities;

use Somnambulist\Domain\Entities\Contracts\CanTestEquality;
use function get_class;

/**
 * Class AbstractEntity
 *
 * Represents a child entity within an aggregate root. A child entity does not exists
 * outside of the scope of the aggregate root. If your child entity needs to be
 * accessed separately from the aggregate root, then it is not a child entity, but
 * instead a standalone entity and potentially another aggregate root.
 *
 * @package    Somnambulist\Domain\Entities
 * @subpackage Somnambulist\Domain\Entities\AbstractEntity
 */
abstract class AbstractEntity implements CanTestEquality
{

    protected int $id;
    protected AggregateRoot $root;

    public function id(): int
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
