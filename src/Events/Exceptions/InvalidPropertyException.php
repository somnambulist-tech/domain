<?php declare(strict_types=1);

namespace Somnambulist\Domain\Events\Exceptions;

use InvalidArgumentException;

/**
 * Class InvalidPropertyException
 *
 * @package    Somnambulist\Domain\Events\Exceptions
 * @subpackage Somnambulist\Domain\Events\Exceptions\InvalidPropertyException
 */
class InvalidPropertyException extends InvalidArgumentException
{

    /**
     * @param string $name
     *
     * @return InvalidPropertyException
     */
    public static function propertyDoesNotExist($name): self
    {
        return new static(sprintf('Property "%s" does not exist', $name));
    }
}
