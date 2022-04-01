<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities\Exceptions;

use Exception;
use function sprintf;

/**
 * Class InvalidDomainStateException
 *
 * Exception for when a domain state transition is invalid. Can be extended to provide
 * specific contextual information.
 *
 * @package    Somnambulist\Components\Domain\Entities\Exceptions
 * @subpackage Somnambulist\Components\Domain\Entities\Exceptions\InvalidDomainStateException
 * @codeCoverageIgnore
 */
class InvalidDomainStateException extends Exception
{
    /**
     * @param string $class
     * @param mixed  $identifier
     * @param string $operation
     *
     * @return static
     */
    public static function operationNotPermitted(string $class, mixed $identifier, string $operation): self
    {
        return new static(sprintf('The operation "%s" is not permitted on "%s" with identifier "%s"', $operation, $class, $identifier), 422);
    }

    /**
     * @param string $field
     * @param mixed  $identifier
     *
     * @return static
     */
    public static function entityWithIdentifierAlreadyExists(string $field, mixed $identifier): self
    {
        return new static(sprintf('Entity with identifier "%s" with value "%s" already exists', $field, $identifier), 422);
    }
}
