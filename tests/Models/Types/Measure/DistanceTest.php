<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Models\Types\Measure;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\Measure\Distance;
use Somnambulist\Components\Models\Types\Measure\DistanceUnit;

/**
 * @group models
 * @group models-types
 * @group models-types-distance
 */
class DistanceTest extends TestCase
{
    public function testCreate()
    {
        $vo = new Distance(23.4, DistanceUnit::MILE());

        $this->assertEquals(23.4, $vo->value());
        $this->assertEquals(DistanceUnit::MILE(), $vo->unit());
    }

    public function testCanCastToString()
    {
        $vo = new Distance(23.4, DistanceUnit::MILE());

        $this->assertEquals('23.4 mi', (string)$vo);
    }

    public function testCanTestEquality()
    {
        $vo = new Distance(23.4, DistanceUnit::MILE());

        $this->assertTrue($vo->equals($vo));

        $vo2 = new Distance(23.4, DistanceUnit::KM());

        $this->assertFalse($vo->equals($vo2));
    }
}
