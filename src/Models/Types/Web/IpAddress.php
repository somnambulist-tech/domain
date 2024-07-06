<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types\Web;

use Somnambulist\Components\Models\AbstractValueObject;

/**
 * Represents an IP address in the domain
 */
abstract readonly class IpAddress extends AbstractValueObject
{
    public function __construct(protected string $value)
    {
    }

    public function toString(): string
    {
        return $this->value;
    }
}
