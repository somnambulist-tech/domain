<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Entities\Types\DateTime;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Domain\Entities\Types\DateTime\DateTime;
use Somnambulist\Components\Domain\Entities\Types\Measure\AreaUnit;

/**
 * Class DateTimeTest
 *
 * @package    Somnambulist\Components\Domain\Tests\Entities\Types\DateTime
 * @subpackage Somnambulist\Components\Domain\Tests\Entities\Types\DateTime\DateTimeTest
 *
 * @group      entities
 * @group      entities-types
 * @group      entities-types-datetime
 */
class DateTimeTest extends TestCase
{

    use Helpers;

    public function testCanCastToString()
    {
        $vo = new DateTime('2017-06-17 12:00:00', new \DateTimeZone('UTC'));

        $this->assertEquals('2017-06-17 12:00:00', (string)$vo);
    }

    public function testCanTestEquality()
    {
        $vo1 = new DateTime();
        $vo2 = $vo1->clone();
        $vo3 = new DateTime('yesterday', new \DateTimeZone('Pacific/Honolulu'));

        $this->assertTrue($vo1->equals($vo2));
        $this->assertFalse($vo1->equals($vo3));
    }

    public function testCanCompareOtherObjects()
    {
        $vo1 = new DateTime();
        $vo2 = AreaUnit::SQ_M();

        $this->assertFalse($vo1->equals($vo2));
    }

    public function testCantSetArbitraryProperties()
    {
        $vo      = new DateTime();
        $vo->foo = 'bar';

        $this->assertObjectNotHasAttribute('foo', $vo);
    }
}
