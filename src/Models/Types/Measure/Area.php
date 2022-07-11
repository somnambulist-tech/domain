<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types\Measure;

use Somnambulist\Components\Models\AbstractValueObject;
use function sprintf;

/**
 * Represents an area with units in the domain
 */
final class Area extends AbstractValueObject
{
    public function __construct(private float $value, private AreaUnit $unit)
    {
    }

    public function toString(): string
    {
        return sprintf('%s %s', $this->value, $this->unit);
    }

    public function value(): float
    {
        return $this->value;
    }

    public function unit(): AreaUnit
    {
        return $this->unit;
    }
}
