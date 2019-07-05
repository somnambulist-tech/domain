<?php

namespace Somnambulist\Domain\Tests\Entities\Types\Measure;

use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Entities\Types\Measure\Distance;
use Somnambulist\Domain\Entities\Types\Measure\DistanceUnit;

/**
 * Class DistanceTest
 *
 * @package    Somnambulist\Domain\Tests\Entities\Types\Measure
 * @subpackage Somnambulist\Domain\Tests\Entities\Types\Measure\DistanceTest
 */
class DistanceTest extends TestCase
{

    /**
     * @group value-objects
     * @group value-objects-distance
     */
    public function testCreate()
    {
        $vo = new Distance(23.4, DistanceUnit::MILE());

        $this->assertEquals(23.4, $vo->value());
        $this->assertEquals(DistanceUnit::MILE(), $vo->unit());
    }

    /**
     * @group value-objects
     * @group value-objects-distance
     */
    public function testCanCastToString()
    {
        $vo = new Distance(23.4, DistanceUnit::MILE());

        $this->assertEquals('23.4', (string)$vo);
    }

    /**
     * @group value-objects
     * @group value-objects-distance
     */
    public function testCanTestEquality()
    {
        $vo = new Distance(23.4, DistanceUnit::MILE());

        $this->assertTrue($vo->equals($vo));

        $vo2 = new Distance(23.4, DistanceUnit::KM());

        $this->assertFalse($vo->equals($vo2));
    }
}
