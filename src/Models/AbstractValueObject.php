<?php declare(strict_types=1);

namespace Somnambulist\Components\Models;

use ReflectionObject;
use Somnambulist\Components\Collection\MutableCollection as Collection;
use Somnambulist\Components\Models\Contracts\ValueObject;

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
 *
 * For PHP <8.1 this implementation ensures that the value object is read-only and does
 * not allow dynamic properties.
 */
abstract class AbstractValueObject implements ValueObject
{
    public function __set($name, $value) {}
    public function __unset($name) {}

    public function __toString(): string
    {
        return $this->toString();
    }

    public function equals(object $object): bool
    {
        if (get_class($this) !== get_class($object)) {
            return false;
        }

        $props = Collection::collect((new ReflectionObject($this))->getProperties());
        $props->run->setAccessible(true);

        return $props
            ->filter(fn ($prop) => (string)$prop->getValue($object) === (string)$prop->getValue($this))
            ->count() === $props->count()
        ;
    }
}
