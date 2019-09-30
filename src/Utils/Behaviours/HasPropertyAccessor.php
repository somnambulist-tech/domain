<?php declare(strict_types=1);

namespace Somnambulist\Domain\Utils\Behaviours;

use Somnambulist\Domain\Events\Exceptions\InvalidPropertyException;

/**
 * Trait HasPropertyAccessor
 *
 * Allows calling protected / private properties if they exist. E.g.: an event
 * or command can implement this to maintain protected properties, but still
 * access them using standard property accessors.
 *
 * @package    Somnambulist\Domain\Utils\Behaviours
 * @subpackage Somnambulist\Domain\Utils\Behaviours\HasPropertyAccessor
 */
trait HasPropertyAccessor
{

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->{$name};
        }

        throw InvalidPropertyException::propertyDoesNotExist($name);
    }
}
