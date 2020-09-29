<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities\Exceptions;

use function implode;
use function sprintf;

/**
 * Class InvalidDomainConstraintException
 *
 * @package    Somnambulist\Components\Domain\Entities\Exceptions
 * @subpackage Somnambulist\Components\Domain\Entities\Exceptions\InvalidDomainConstraintException
 * @codeCoverageIgnore
 */
class InvalidDomainConstraintException extends InvalidDomainStateException
{

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
