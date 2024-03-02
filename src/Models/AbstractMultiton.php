<?php declare(strict_types=1);

namespace Somnambulist\Components\Models;

use Somnambulist\Components\Enumeration\AbstractMultiton as BaseMultiton;
use Somnambulist\Components\Models\Contracts\ValueObject;

abstract class AbstractMultiton extends BaseMultiton implements ValueObject
{
    protected static array $cache = [];

    public static function keys(): array
    {
        $class = get_called_class();

        if (!isset(static::$cache[$class])) {
            static::$cache[$class] = [];

            foreach (static::members() as $member) {
                static::$cache[$class][$member->key()] = $member->key();
            }
        }

        return static::$cache[$class];
    }

    public static function hasKey($key): bool
    {
        return array_key_exists($key, static::keys());
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
