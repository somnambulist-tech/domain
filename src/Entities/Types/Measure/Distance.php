<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types\Measure;

use Somnambulist\Domain\Entities\AbstractValueObject;

/**
 * Class Distance
 *
 * @package    Somnambulist\Domain\Entities\Types\Measure
 * @subpackage Somnambulist\Domain\Entities\Types\Measure\Distance
 */
class Distance extends AbstractValueObject
{

    /**
     * @var float
     */
    private $value;

    /**
     * @var DistanceUnit
     */
    private $unit;

    /**
     * Constructor.
     *
     * @param float    $value
     * @param DistanceUnit $unit
     */
    public function __construct(float $value, DistanceUnit $unit)
    {
        $this->value = $value;
        $this->unit  = $unit;
    }

    public function toString(): string
    {
        return (string)$this->value;
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
