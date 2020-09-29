<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities\Types\Measure;

use Somnambulist\Components\Domain\Entities\AbstractValueObject;
use function sprintf;

/**
 * Class Distance
 *
 * @package    Somnambulist\Components\Domain\Entities\Types\Measure
 * @subpackage Somnambulist\Components\Domain\Entities\Types\Measure\Distance
 */
final class Distance extends AbstractValueObject
{

    private float $value;
    private DistanceUnit $unit;

    public function __construct(float $value, DistanceUnit $unit)
    {
        $this->value = $value;
        $this->unit  = $unit;
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
