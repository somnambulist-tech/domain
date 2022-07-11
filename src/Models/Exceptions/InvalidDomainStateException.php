<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Exceptions;

use Exception;
use function sprintf;

/**
 * Exception for when a domain state transition is invalid.
 *
 * Can be extended to provide domain specific contextual information.
 *
 * @codeCoverageIgnore
 */
class InvalidDomainStateException extends Exception
{
    public static function operationNotPermitted(string $class, mixed $identifier, string $operation): self
    {
        return new static(sprintf('The operation "%s" is not permitted on "%s" with identifier "%s"', $operation, $class, $identifier), 422);
    }

    public static function entityWithIdentifierAlreadyExists(string $field, mixed $identifier): self
    {
        return new static(sprintf('Entity with identifier "%s" with value "%s" already exists', $field, $identifier), 422);
    }
}
