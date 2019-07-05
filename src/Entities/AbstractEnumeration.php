<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities;

use Eloquent\Enumeration\AbstractEnumeration as BaseEnumeration;
use Somnambulist\Domain\Entities\Contracts\ValueObjectInterface;

/**
 * Class AbstractEnumeration
 *
 * @package    Somnambulist\Domain\Entities
 * @subpackage Somnambulist\Domain\Entities\AbstractEnumeration
 */
abstract class AbstractEnumeration extends BaseEnumeration implements ValueObjectInterface
{
    /**
     * Cache of pre-built member data indexed by key
     *
     * @var array
     */
    protected static $cache = [];

    /**
     * @return array
     */
    public static function values()
    {
        $class = get_called_class();

        if (!isset(static::$cache[$class])) {
            static::$cache[$class] = [];

            /** @var static $member */
            foreach (static::members() as $member) {
                static::$cache[$class][$member->key()] = $member->value();
            }
        }

        return static::$cache[$class];
    }

    public static function hasKey($value): bool
    {
        return in_array($value, array_keys(static::values()));
    }

    public static function hasValue($value): bool
    {
        return in_array($value, array_values(static::values()));
    }

    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @param string $name
     * @param mixed  $value
     */
    public function __set($name, $value)
    {
        // prevent arbitrary properties
    }

    public function toString(): string
    {
        return (string)$this->value();
    }

    public function equals(object $object): bool
    {
        if (get_class($object) !== get_class($this)) {
            return false;
        }

        return $this->value() === $object->value();
    }
}
