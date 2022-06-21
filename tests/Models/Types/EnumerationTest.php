<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Models\Types;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\Geography\Srid;

/**
 * @group models
 * @group models-types
 * @group models-types-enumeration
 */
class EnumerationTest extends TestCase
{
    public function testValues()
    {
        $values = Srid::values();

        $expected = [
            'BRITISH_NATIONAL_GRID' => 27700,
            'OSGB1936'              => 27700,
            'WGS84'                 => 4326,
        ];

        $this->assertEquals($expected, $values);
    }

    public function testHasKey()
    {
        $this->assertTrue(Srid::hasKey('WGS84'));
        $this->assertFalse(Srid::hasKey('bob'));
    }

    public function testHasValue()
    {
        $this->assertTrue(Srid::hasValue(4326));
        $this->assertFalse(Srid::hasValue('bob'));
    }
}
