<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types\Web;

use Somnambulist\Components\Models\AbstractValueObject;

/**
 * Represents an IP address in the domain
 */
abstract class IpAddress extends AbstractValueObject
{
    protected string $value;

    public function toString(): string
    {
        return $this->value;
    }
}
