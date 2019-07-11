<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities;

use ReflectionObject;
use ReflectionProperty;
use Somnambulist\Collection\MutableCollection as Collection;
use Somnambulist\Domain\Entities\Contracts\ValueObjectInterface;

/**
 * Class AbstractValueObject
 *
 * @package    AppBundle\ValueObjects
 * @subpackage AppBundle\ValueObjects\AbstractValueObject
 */
abstract class AbstractValueObject implements ValueObjectInterface
{

    /**
     * @param string $name
     * @param mixed  $value
     */
    public function __set($name, $value)
    {
        // prevent arbitrary properties
    }

    public function __toString()
    {
        return (string)$this->toString();
    }

    public function equals(object $object): bool
    {
        if (get_class($this) === get_class($object)) {
            $props = Collection::collect((new ReflectionObject($this))->getProperties());

            return $props
                ->filter(function ($prop) use ($object) {
                    /** @var ReflectionProperty $prop */
                    $prop->setAccessible(true);

                    return (string)$prop->getValue($object) === (string)$prop->getValue($this);
                })
                ->count() === $props->count()
            ;
        }

        return false;
    }
}
