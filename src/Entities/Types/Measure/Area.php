<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types\Measure;

use Somnambulist\Domain\Entities\AbstractValueObject;
use function sprintf;

/**
 * Class Area
 *
 * @package    Somnambulist\Domain\Entities\Types\Measure
 * @subpackage Somnambulist\Domain\Entities\Types\Measure\Area
 */
final class Area extends AbstractValueObject
{

    private float $value;
    private AreaUnit $unit;

    public function __construct(float $value, AreaUnit $unit)
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

    public function unit(): AreaUnit
    {
        return $this->unit;
    }
}
