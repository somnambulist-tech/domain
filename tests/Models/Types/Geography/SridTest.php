<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Models\Types\Geography;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\Geography\Srid;

/**
 * @group models
 * @group models-types
 * @group models-types-srid
 */
class SridTest extends TestCase
{
    public function testCreate()
    {
        $vo = Srid::WGS84();

        $this->assertEquals('4326', $vo->toString());
    }

    public function testCanCastToString()
    {
        $vo = Srid::WGS84();

        $this->assertEquals('4326', (string)$vo);
    }
}
