<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Exceptions;

use Exception;
use function implode;
use function sprintf;

/**
 * Class InvalidDomainConstraintException
 *
 * @package    Somnambulist\Domain\Entities\Exceptions
 * @subpackage Somnambulist\Domain\Entities\Exceptions\InvalidDomainConstraintException
 * @codeCoverageIgnore
 */
class InvalidDomainConstraintException extends InvalidDomainStateException
{

    /**
     * @param string ...$args
     *
     * @return InvalidDomainConstraintException
     */
    public static function mustHaveOneOf(string ...$args): self
    {
        return new static(
            sprintf(
                'The entity must receive a non-null value for one of: %s',
                implode(', ', $args)
            )
        );
    }
}
