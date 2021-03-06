<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Entities\Types\Geography;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Domain\Entities\Types\Geography\Srid;

/**
 * Class SridTest
 *
 * @package    Somnambulist\Components\Domain\Tests\Entities\Types\Geography
 * @subpackage Somnambulist\Components\Domain\Tests\Entities\Types\Geography\SridTest
 *
 * @group entities
 * @group entities-types
 * @group entities-types-srid
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
