<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Exceptions;

use Exception;
use function sprintf;

/**
 * Class InvalidDomainStateException
 *
 * Exception for when a domain state transition is invalid. Can be extended to provide
 * specific contextual information.
 *
 * @package    Somnambulist\Domain\Entities\Exceptions
 * @subpackage Somnambulist\Domain\Entities\Exceptions\InvalidDomainStateException
 * @codeCoverageIgnore
 */
class InvalidDomainStateException extends Exception
{

    /**
     * @param string     $field
     * @param int|string $identifier
     *
     * @return InvalidDomainStateException
     */
    public static function entityWithIdentifierAlreadyExists(string $field, $identifier): self
    {
        return new static(sprintf('Entity with identifier "%s" with value "%s" already exists', $field, $identifier), 422);
    }
}
