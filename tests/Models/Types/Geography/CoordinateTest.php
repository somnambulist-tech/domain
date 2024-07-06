<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Models\Types\Geography;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\Geography\Coordinate;
use Somnambulist\Components\Models\Types\Geography\Srid;

#[Group('models')]
#[Group('models-types')]
class CoordinateTest extends TestCase
{
    public function testCreate()
    {
        $vo = new Coordinate(4, 7, new Srid(4326));

        $this->assertEquals(4, $vo->latitude());
        $this->assertEquals(7, $vo->longitude());
        $this->assertEquals('4326', $vo->srid()->toString());
    }

    public function testCanCastToString()
    {
        $vo = new Coordinate(4, 7, Srid::WGS84());

        $this->assertEquals('[7, 4]', (string)$vo);
    }

    public function testCanCastToGeoJson()
    {
        $vo = new Coordinate(4, 7, Srid::WGS84());

        $this->assertEquals('{"type":"Point","coordinates":[7,4],"crs":{"type":"name","properties":{"name":"EPSG:4326"}}}', $vo->toGeoJson());
    }
}
