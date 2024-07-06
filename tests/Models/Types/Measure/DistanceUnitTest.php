<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Models\Types\Measure;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\Measure\AreaUnit;
use Somnambulist\Components\Models\Types\Measure\DistanceUnit;

#[Group('models')]
#[Group('models-types')]
class DistanceUnitTest extends TestCase
{
    public function testCanCompare()
    {
        $vo1 = DistanceUnit::FEET;
        $vo2 = DistanceUnit::KM;

        $this->assertTrue($vo1->equals($vo1));
        $this->assertFalse($vo1->equals($vo2));
    }

    public function testCanCompareOtherObjects()
    {
        $vo1 = AreaUnit::SQ_FT;
        $vo2 = DistanceUnit::KM;

        $this->assertFalse($vo1->equals($vo2));
    }
}
