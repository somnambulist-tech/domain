<?php

namespace Somnambulist\Domain\Tests\Entities\Types;

use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Entities\Types\Geography\Srid;

/**
 * Class EnumerationTest
 *
 * @package    Somnambulist\Domain\Tests\Entities\Types
 * @subpackage Somnambulist\Domain\Tests\Entities\Types\EnumerationTest
 */
class EnumerationTest extends TestCase
{

    /**
     * @group enumeration
     */
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

    /**
     * @group enumeration
     */
    public function testHasKey()
    {
        $this->assertTrue(Srid::hasKey('WGS84'));
        $this->assertFalse(Srid::hasKey('bob'));
    }

    /**
     * @group enumeration
     */
    public function testHasValue()
    {
        $this->assertTrue(Srid::hasValue(4326));
        $this->assertFalse(Srid::hasValue('bob'));
    }
}
