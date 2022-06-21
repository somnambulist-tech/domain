<?php declare(strict_types=1);

namespace Somnambulist\Components\Utils;

use Closure;
use ReflectionObject;
use function is_null;
use function is_object;
use function property_exists;

final class EntityAccessor
{
    private function __construct() {}

    /**
     * Helper to allow calling protected/private methods with variable arguments
     *
     * @param object             $object
     * @param string             $method
     * @param null|string|object $scope
     * @param mixed              ...$args
     *
     * @return mixed
     */
    public static function call(object $object, string $method, mixed $scope = null, mixed ...$args)
    {
        return Closure::bind(fn () => $this->{$method}(...$args), $object, !is_null($scope) ? $scope : $object)();
    }

    /**
     * Helper to check if the object has a property with the name
     *
     * @param object             $object
     * @param string             $property
     * @param null|string|object $scope
     *
     * @return bool
     */
    public static function has(object $object, string $property, mixed $scope = null): bool
    {
        return Closure::bind(fn () => property_exists($this, $property), $object, !is_null($scope) ? $scope : $object)();
    }

    /**
     * Helper to allow getting protected/private properties, returns the property value
     *
     * @param object             $object
     * @param string             $property
     * @param null|string|object $scope
     *
     * @return mixed
     */
    public static function get(object $object, string $property, mixed $scope = null)
    {
        return Closure::bind(fn () => $this->{$property}, $object, !is_null($scope) ? $scope : $object)();
    }

    /**
     * Helper to allow setting protected/private properties, returns the passed object
     *
     * @param object             $object
     * @param string             $property
     * @param mixed              $value
     * @param null|string|object $scope
     *
     * @return object
     */
    public static function set(object $object, string $property, mixed $value, mixed $scope = null): object
    {
        Closure::bind(fn () => $this->{$property} = $value, $object, !is_null($scope) ? $scope : $object)();

        return $object;
    }

    /**
     * Extracts all properties (including parent private properties) from the given object
     *
     * @param object $value
     * @param bool   $ignoreStatic  if true, ignores static properties (recommended)
     * @param bool   $recurseValues if true, extracts properties from sub-objects
     *
     * @return array
     * @experimental added in 4.2.0
     */
    public static function extract(object $value, bool $ignoreStatic = true, bool $recurseValues = false): array
    {
        $arr    = [];
        $refObj = new ReflectionObject($value);

        do {
            foreach ($refObj->getProperties() as $prop) {
                if ($prop->isStatic() && $ignoreStatic) {
                    continue;
                }

                $prop->setAccessible(true);

                $v = $prop->getValue($value);

                if (is_object($v) && $recurseValues) {
                    $v = self::extract($v, $ignoreStatic, $recurseValues);
                } elseif (is_array($v) && $recurseValues) {
                    $t = [];
                    foreach ($v as $key => $val) {
                        $t[$key] = is_object($val) ? self::extract($val, $ignoreStatic, $recurseValues) : $val;
                    }
                    $v = $t;
                }

                $arr[$prop->getName()] = $v;
            }
        } while ($refObj = $refObj->getParentClass());

        return $arr;
    }
}
