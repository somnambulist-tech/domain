<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Entities\Types\Measure;

use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Entities\Types\Measure\AreaUnit;
use Somnambulist\Domain\Entities\Types\Measure\DistanceUnit;

/**
 * Class DistanceUnitTest
 *
 * @package    Somnambulist\Domain\Tests\Entities\Types\Measure
 * @subpackage Somnambulist\Domain\Tests\Entities\Types\Measure\DistanceUnitTest
 *
 * @group entities
 * @group entities-types
 * @group entities-types-distance
 */
class DistanceUnitTest extends TestCase
{

    public function testCanCompare()
    {
        $vo1 = DistanceUnit::FEET();
        $vo2 = DistanceUnit::KM();

        $this->assertTrue($vo1->equals($vo1));
        $this->assertFalse($vo1->equals($vo2));
    }

    public function testCanCompareOtherObjects()
    {
        $vo1 = AreaUnit::SQ_FT();
        $vo2 = DistanceUnit::KM();

        $this->assertFalse($vo1->equals($vo2));
    }

    public function testCantSetArbitraryProperties()
    {
        $vo = DistanceUnit::FEET();
        $vo->foo = 'bar';

        $this->assertObjectNotHasAttribute('foo', $vo);
    }
}
