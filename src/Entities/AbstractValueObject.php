<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities;

use ReflectionObject;
use Somnambulist\Collection\MutableCollection as Collection;
use Somnambulist\Domain\Entities\Contracts\ValueObject;

/**
 * Class AbstractValueObject
 *
 * @package    Somnambulist\Domain\Entities
 * @subpackage Somnambulist\Domain\Entities\AbstractValueObject
 */
abstract class AbstractValueObject implements ValueObject
{

    public function __set($name, $value) {}

    public function __toString()
    {
        return (string)$this->toString();
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
