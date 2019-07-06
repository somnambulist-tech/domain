<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities;

use Eloquent\Enumeration\AbstractMultiton as BaseMultiton;
use Somnambulist\Domain\Entities\Contracts\ValueObjectInterface;

/**
 * Class AbstractMultiton
 *
 * @package    Somnambulist\Domain\Entities
 * @subpackage Somnambulist\Domain\Entities\AbstractMultiton
 */
abstract class AbstractMultiton extends BaseMultiton implements ValueObjectInterface
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
    public static function keys()
    {
        $class = get_called_class();

        if (!isset(static::$cache[$class])) {
            static::$cache[$class] = [];

            /** @var static $member */
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

    /**
     * @param string $name
     * @param mixed  $value
     */
    public function __set($name, $value)
    {
        // prevent arbitrary properties
    }
}
