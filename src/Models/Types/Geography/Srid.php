<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types\Geography;

use Assert\Assert;
use Somnambulist\Components\Models\AbstractValueObject;

/**
 * Represents a Spatial Reference System Identifier
 *
 * This is a unique value for a spatial reference system, see: https://spatialreference.org/ref/epsg/
 * For example: WGS84 has a SRID of 4326; BNG has a SRID of 27700.
 */
final readonly class Srid extends AbstractValueObject
{
    public static function WGS84(): self
    {
        return new self(4326);
    }

    public function __construct(private int $value)
    {
        Assert::that($this->value)->integer()->greaterThan(0);
    }

    public function value(): int
    {
        return $this->value;
    }

    public function toString(): string
    {
        return (string)$this->value;
    }
}
