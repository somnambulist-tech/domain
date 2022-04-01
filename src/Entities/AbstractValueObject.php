<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities;

use ReflectionObject;
use Somnambulist\Components\Collection\MutableCollection as Collection;
use Somnambulist\Components\Domain\Entities\Contracts\ValueObject;

/**
 * Class AbstractValueObject
 *
 * @package    Somnambulist\Components\Domain\Entities
 * @subpackage Somnambulist\Components\Domain\Entities\AbstractValueObject
 */
abstract class AbstractValueObject implements ValueObject
{
    public function __set($name, $value) {}

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
