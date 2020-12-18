<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities;

use Eloquent\Enumeration\AbstractMultiton as BaseMultiton;
use Somnambulist\Components\Domain\Entities\Contracts\ValueObject;

/**
 * Class AbstractMultiton
 *
 * @package    Somnambulist\Components\Domain\Entities
 * @subpackage Somnambulist\Components\Domain\Entities\AbstractMultiton
 */
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

    public function __toString()
    {
        return $this->toString();
    }

    public function __set($name, $value) {}

    public function __unset($name) {}
}
