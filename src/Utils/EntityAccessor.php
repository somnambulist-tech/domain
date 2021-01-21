<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Utils;

use Closure;
use function is_null;
use function property_exists;

/**
 * Class EntityAccessor
 *
 * @package    Somnambulist\Components\Domain\Utils
 * @subpackage Somnambulist\Components\Domain\Utils\EntityAccessor
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
}
