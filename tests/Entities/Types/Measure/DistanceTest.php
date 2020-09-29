<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Entities\Types\Measure;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Domain\Entities\Types\Measure\Distance;
use Somnambulist\Components\Domain\Entities\Types\Measure\DistanceUnit;

/**
 * Class DistanceTest
 *
 * @package    Somnambulist\Components\Domain\Tests\Entities\Types\Measure
 * @subpackage Somnambulist\Components\Domain\Tests\Entities\Types\Measure\DistanceTest
 *
 * @group entities
 * @group entities-types
 * @group entities-types-distance
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
