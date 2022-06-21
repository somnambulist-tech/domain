<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types\Measure;

use Somnambulist\Components\Models\AbstractValueObject;
use function sprintf;

/**
 * Represents a distance and unit in the domain
 */
final class Distance extends AbstractValueObject
{
    public function __construct(private float $value, private DistanceUnit $unit)
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

    public function unit(): DistanceUnit
    {
        return $this->unit;
    }
}
