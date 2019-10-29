<?php declare(strict_types=1);

namespace Somnambulist\Domain\Utils\Tests\Assertions;

use Somnambulist\Domain\Utils\EntityAccessor;
use function get_class;

/**
 * Trait AssertEntityHasPropertyWithValue
 *
 * Assert that an entity has a given property with value. Needed to test entities without
 * public getters.
 *
 * @package Somnambulist\Domain\Utils\Tests\Assertions
 * @subpackage Somnambulist\Domain\Utils\Tests\Assertions\AssertEntityHasPropertyWithValue
 */
trait AssertEntityHasPropertyWithValue
{

    /**
     * @param object $entity
     * @param string $property The property to check for presence and value
     * @param mixed  $expected The expected value; will be passed to `assertEquals()`
     * @param mixed  $scope    Scope defines the level of access, if null the current entity is used.
     *                         For certain private properties, this may need to be set to the parent class.
     */
    public function assertEntityHasPropertyWithValue(object $entity, string $property, $expected, $scope = null)
    {
        $this->assertTrue(
            EntityAccessor::has($entity, $property, $scope ?? $entity),
            sprintf('Object of type "%s" does not have a property "%s"; do you need a custom scope?', get_class($entity), $property)
        );

        $value = EntityAccessor::get($entity, $property, $scope ?? $entity);

        $this->assertEquals(
            $expected, $value,
            sprintf('Object of type "%s" has a property "%s" but the value did not match the expected', get_class($entity), $property)
        );
    }
}
