<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Entities\Types\DateTime;

use DateTimeZone;
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
        $vo = new DateTime('2017-06-17 12:00:00', new DateTimeZone('UTC'));

        $this->assertEquals('2017-06-17 12:00:00', (string)$vo);
    }

    public function testCanTestEquality()
    {
        $vo1 = new DateTime();
        $vo2 = $vo1->clone();
        $vo3 = new DateTime('yesterday', new DateTimeZone('Pacific/Honolulu'));

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

    public function testToUtc()
    {
        $dt = new DateTime('2001-02-03 04:05:06.007+08:00');

        $this->assertEquals(new \DateTime('2001-02-02 20:05:06.007+00:00'), $dt->toUtc());
    }

    public function testFirstDayOfWeek()
    {
        $this->assertEquals(1, (new DateTime())->firstDayOfWeek());
    }

    public function testLastDayOfWeek()
    {
        $this->assertEquals(0, (new DateTime())->lastDayOfWeek());
    }

    /** @dataProvider lastDayOfWeekTestData */
    public function testLastDayOfWeekGivenFirstDayOfWeek(int $firstDow, int $lastDow)
    {
        $this->assertEquals($lastDow, (new DateTime())->lastDayOfWeek($firstDow));
    }

    public function lastDayOfWeekTestData(): array
    {
        // [ firstDow, lastDow ]
        return [
            [0, 6], [1, 0], [2, 1], [3, 2], [4, 3], [5, 4], [6, 5],
            // out-of-range should still work
            [7, 6], [8, 0],
        ];
    }
}
