<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Entities\Types;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Domain\Entities\Types\Geography\Srid;

/**
 * Class EnumerationTest
 *
 * @package    Somnambulist\Components\Domain\Tests\Entities\Types
 * @subpackage Somnambulist\Components\Domain\Tests\Entities\Types\EnumerationTest
 *
 * @group entities
 * @group entities-types
 * @group entities-types-enumeration
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
