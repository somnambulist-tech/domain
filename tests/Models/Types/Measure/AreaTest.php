<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Models\Types\Measure;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\Measure\Area;
use Somnambulist\Components\Models\Types\Measure\AreaUnit;

/**
 * @group models
 * @group models-types
 * @group models-types-area
 */
class AreaTest extends TestCase
{
    public function testCreate()
    {
        $vo = new Area(23.4, AreaUnit::SQ_FT());

        $this->assertEquals(23.4, $vo->value());
        $this->assertEquals(AreaUnit::SQ_FT(), $vo->unit());
    }

    public function testCanCastToString()
    {
        $vo = new Area(23.4, AreaUnit::SQ_FT());

        $this->assertEquals('23.4 sq_ft', (string)$vo);
    }

    public function testCanCompareEquality()
    {
        $vo1 = new Area(23.4, AreaUnit::SQ_FT());
        $vo2 = new Area(23.4, AreaUnit::SQ_M());

        $this->assertTrue($vo1->equals($vo1));
        $this->assertFalse($vo1->equals($vo2));
    }
}
