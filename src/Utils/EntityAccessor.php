<?php declare(strict_types=1);

namespace Somnambulist\Domain\Utils;

use Closure;
use function property_exists;

/**
 * Class EntityAccessor
 *
 * @package    Somnambulist\Domain\Utils
 * @subpackage Somnambulist\Domain\Utils\EntityAccessor
 */
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
    public static function call(object $object, string $method, $scope = null, ...$args)
    {
        return Closure::bind(function () use ($method, $args) {
            return $this->{$method}(...$args);
        }, $object, !is_null($scope) ? $scope : 'static')();
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
    public static function has(object $object, string $property, $scope = null): bool
    {
        return Closure::bind(function () use ($property) {
            return property_exists($this, $property);
        }, $object, !is_null($scope) ? $scope : 'static')();
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
    public static function get(object $object, string $property, $scope = null)
    {
        return Closure::bind(function () use ($property) {
            return $this->{$property};
        }, $object, !is_null($scope) ? $scope : 'static')();
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
    public static function set(object $object, string $property, $value, $scope = null): object
    {
        Closure::bind(function () use ($property, $value) {
            $this->{$property} = $value;
        }, $object, !is_null($scope) ? $scope : 'static')();

        return $object;
    }
}
