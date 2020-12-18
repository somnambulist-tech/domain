<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities;

use Eloquent\Enumeration\AbstractEnumeration as BaseEnumeration;
use Somnambulist\Components\Domain\Entities\Contracts\ValueObject;

/**
 * Class AbstractEnumeration
 *
 * @package    Somnambulist\Components\Domain\Entities
 * @subpackage Somnambulist\Components\Domain\Entities\AbstractEnumeration
 */
abstract class AbstractEnumeration extends BaseEnumeration implements ValueObject
{

    protected static array $cache = [];

    public static function values(): array
    {
        $class = get_called_class();

        if (!isset(static::$cache[$class])) {
            static::$cache[$class] = [];

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

    public function __set($name, $value) {}

    public function __unset($name) {}

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
