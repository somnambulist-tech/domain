<?php declare(strict_types=1);

namespace Somnambulist\Components\Models;

use Somnambulist\Components\Models\Contracts\ValueObject;
use Somnambulist\Components\Utils\ObjectDiff;

/**
 * A value object implementation
 *
 * A value object represents an entity without a continuous thread of identity in your
 * bounded context. Note: these are still entities and are not special. They should not
 * be namespaced.
 *
 * Value objects are read-only and should never allow the properties to be changed once
 * created. A value object should always be replaced with another value object. When backed
 * by Doctrine, value objects should be treated as embeddables.
 */
abstract readonly class AbstractValueObject implements ValueObject
{
    public function __toString(): string
    {
        return $this->toString();
    }

    public function equals(object $object): bool
    {
        if (get_class($this) !== get_class($object)) {
            return false;
        }

        return ObjectDiff::equal($this, $object);
    }
}
