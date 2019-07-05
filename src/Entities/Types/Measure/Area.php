<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types\Measure;

use Somnambulist\Domain\Entities\AbstractValueObject;

/**
 * Class Area
 *
 * @package    Somnambulist\Domain\Entities\Types\Measure
 * @subpackage Somnambulist\Domain\Entities\Types\Measure\Area
 */
class Area extends AbstractValueObject
{

    /**
     * @var float
     */
    private $value;

    /**
     * @var AreaUnit
     */
    private $unit;

    /**
     * Constructor.
     *
     * @param float    $value
     * @param AreaUnit $unit
     */
    public function __construct(float $value, AreaUnit $unit)
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

    public function unit(): AreaUnit
    {
        return $this->unit;
    }
}
