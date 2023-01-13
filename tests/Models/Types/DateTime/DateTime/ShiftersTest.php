<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Models\Types\DateTime\DateTime;

use DateTime as PhpDateTime;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\DateTime\DateTime;

/**
 * @group      models
 * @group      models-types
 * @group      models-types-datetime
 */
class ShiftersTest extends TestCase
{
    protected const TEST_DATE = '2001-02-03 04:05:06.007+08:00'; // Saturday

    public function testStartOfMinute()
    {
        $expected = new PhpDateTime('2001-02-03 04:05:00+08:00');
        $testDate = new DateTime(self::TEST_DATE);

        $this->assertEquals($expected, $testDate->startOfMinute());
        $this->assertEquals($expected, $testDate->startOf('minute'));
    }

    public function testEndOfMinute()
    {
        $expected = new PhpDateTime('2001-02-03 04:05:59+08:00');
        $testDate = new DateTime(self::TEST_DATE);

        $this->assertEquals($expected, $testDate->endOfMinute());
        $this->assertEquals($expected, $testDate->endOf('minute'));
    }

    public function testStartOfHour()
    {
        $expected = new PhpDateTime('2001-02-03 04:00:00+08:00');
        $testDate = new DateTime(self::TEST_DATE);

        $this->assertEquals($expected, $testDate->startOfHour());
        $this->assertEquals($expected, $testDate->startOf('hour'));
    }

    public function testEndOfHour()
    {
        $expected = new PhpDateTime('2001-02-03 04:59:59+08:00');
        $testDate = new DateTime(self::TEST_DATE);

        $this->assertEquals($expected, $testDate->endOfHour());
        $this->assertEquals($expected, $testDate->endOf('hour'));
    }

    public function testStartOfDay()
    {
        $expected = new PhpDateTime('2001-02-03 00:00:00+08:00');
        $testDate = new DateTime(self::TEST_DATE);

        $this->assertEquals($expected, $testDate->startOfDay());
        $this->assertEquals($expected, $testDate->startOf('day'));
    }

    public function testEndOfDay()
    {
        $expected = new PhpDateTime('2001-02-03 23:59:59+08:00');
        $testDate = new DateTime(self::TEST_DATE);

        $this->assertEquals($expected, $testDate->endOfDay());
        $this->assertEquals($expected, $testDate->endOf('day'));
    }

    public function testStartOfWeek()
    {
        $expected = new PhpDateTime('2001-01-29 00:00:00+08:00');
        $testDate = new DateTime(self::TEST_DATE);

        $this->assertEquals($expected, $testDate->startOfWeek());
        $this->assertEquals($expected, $testDate->startOf('week'));
    }

    /** @dataProvider startOfWeekTestData */
    public function testStartOfWeekGivenFirstDayOfWeek(string $testDate, int $firstDow, string $expectedDate)
    {
        $expected = new PhpDateTime("$expectedDate 00:00:00+08:00");
        $testDate = new DateTime($testDate);

        $this->assertEquals($expected, $testDate->startOfWeek($firstDow));
        $this->assertEquals($expected, $testDate->startOf('week', $firstDow));
    }

    public function startOfWeekTestData(): array
    {
        // [ testDate, firstDow, expectedDate ]
        return [
            [self::TEST_DATE, 0, '2001-01-28'],
            [self::TEST_DATE, 1, '2001-01-29'],
            [self::TEST_DATE, 2, '2001-01-30'],
            [self::TEST_DATE, 3, '2001-01-31'],
            [self::TEST_DATE, 4, '2001-02-01'],
            [self::TEST_DATE, 5, '2001-02-02'],
            [self::TEST_DATE, 6, '2001-02-03'],
            // out-of-range should still work
            [self::TEST_DATE, 7, '2001-01-28'],
            [self::TEST_DATE, 8, '2001-01-29'],
            // test start-of-year
            ['2003-01-04 +0800', 0, '2002-12-29'],
            ['2003-01-04 +0800', 1, '2002-12-30'],
            ['2003-01-04 +0800', 2, '2002-12-31'],
            ['2003-01-04 +0800', 3, '2003-01-01'],
            ['2003-01-04 +0800', 4, '2003-01-02'],
            ['2003-01-04 +0800', 5, '2003-01-03'],
            ['2003-01-04 +0800', 6, '2003-01-04'],
            // out-of-range should still work
            ['2003-01-04 +0800', 7, '2002-12-29'],
            ['2003-01-04 +0800', 8, '2002-12-30'],
        ];
    }

    public function testEndOfWeek()
    {
        $expected = new PhpDateTime('2001-02-04 23:59:59+08:00');
        $testDate = new DateTime(self::TEST_DATE);

        $this->assertEquals($expected, $testDate->endOfWeek());
        $this->assertEquals($expected, $testDate->endOf('week'));
    }

    /** @dataProvider endOfWeekTestData */
    public function testEndOfWeekGivenFirstDayOfWeek(string $testDate, int $firstDow, string $expectedDate)
    {
        $expected = new PhpDateTime("$expectedDate 23:59:59+08:00");
        $testDate = new DateTime($testDate);

        $this->assertEquals($expected, $testDate->endOfWeek($firstDow));
        $this->assertEquals($expected, $testDate->endOf('week', $firstDow));
    }

    public function endOfWeekTestData(): array
    {
        // [ testDate, firstDow, expectedDate ]
        return [
            [self::TEST_DATE, 0, '2001-02-03'],
            [self::TEST_DATE, 1, '2001-02-04'],
            [self::TEST_DATE, 2, '2001-02-05'],
            [self::TEST_DATE, 3, '2001-02-06'],
            [self::TEST_DATE, 4, '2001-02-07'],
            [self::TEST_DATE, 5, '2001-02-08'],
            [self::TEST_DATE, 6, '2001-02-09'],
            // out-of-range should still work
            [self::TEST_DATE, 7, '2001-02-03'],
            [self::TEST_DATE, 8, '2001-02-04'],
            // test end-of-year
            ['2002-12-28 +0800', 0, '2002-12-28'],
            ['2002-12-28 +0800', 1, '2002-12-29'],
            ['2002-12-28 +0800', 2, '2002-12-30'],
            ['2002-12-28 +0800', 3, '2002-12-31'],
            ['2002-12-28 +0800', 4, '2003-01-01'],
            ['2002-12-28 +0800', 5, '2003-01-02'],
            ['2002-12-28 +0800', 6, '2003-01-03'],
            // out-of-range should still work
            ['2002-12-28 +0800', 7, '2002-12-28'],
            ['2002-12-28 +0800', 8, '2002-12-29'],
        ];
    }

    public function testStartOfMonth()
    {
        $expected = new PhpDateTime('2001-02-01 00:00:00+08:00');
        $testDate = new DateTime(self::TEST_DATE);

        $this->assertEquals($expected, $testDate->startOfMonth());
        $this->assertEquals($expected, $testDate->startOf('month'));
    }

    public function testEndOfMonth()
    {
        $expected = new PhpDateTime('2001-02-28 23:59:59+08:00');
        $testDate = new DateTime(self::TEST_DATE);

        $this->assertEquals($expected, $testDate->endOfMonth());
        $this->assertEquals($expected, $testDate->endOf('month'));
    }

    public function testEndOfMonthLeapYear()
    {
        $expected = new PhpDateTime('2000-02-29 23:59:59+08:00');
        $testDate = new DateTime('2000-02-15 +08:00');

        $this->assertEquals($expected, $testDate->endOfMonth());
        $this->assertEquals($expected, $testDate->endOf('month'));
    }

    public function testStartOfQuarter()
    {
        $expected = new PhpDateTime('2001-01-01 00:00:00+08:00');
        $testDate = new DateTime(self::TEST_DATE);

        $this->assertEquals($expected, $testDate->startOfQuarter());
        $this->assertEquals($expected, $testDate->startOf('quarter'));

        $expected = new PhpDateTime('2001-04-01 00:00:00+08:00');
        $testDate = $testDate->addMonths(3);

        $this->assertEquals($expected, $testDate->startOfQuarter());
        $this->assertEquals($expected, $testDate->startOf('quarter'));

        $expected = new PhpDateTime('2001-07-01 00:00:00+08:00');
        $testDate = $testDate->addMonths(3);

        $this->assertEquals($expected, $testDate->startOfQuarter());
        $this->assertEquals($expected, $testDate->startOf('quarter'));

        $expected = new PhpDateTime('2001-10-01 00:00:00+08:00');
        $testDate = $testDate->addMonths(3);

        $this->assertEquals($expected, $testDate->startOfQuarter());
        $this->assertEquals($expected, $testDate->startOf('quarter'));
    }

    public function testEndOfQuarter()
    {
        $expected = new PhpDateTime('2001-03-31 23:59:59+08:00');
        $testDate = new DateTime(self::TEST_DATE);

        $this->assertEquals($expected, $testDate->endOfQuarter());
        $this->assertEquals($expected, $testDate->endOf('quarter'));

        $expected = new PhpDateTime('2001-06-30 23:59:59+08:00');
        $testDate = $testDate->addMonths(3);

        $this->assertEquals($expected, $testDate->endOfQuarter());
        $this->assertEquals($expected, $testDate->endOf('quarter'));

        $expected = new PhpDateTime('2001-09-30 23:59:59+08:00');
        $testDate = $testDate->addMonths(3);

        $this->assertEquals($expected, $testDate->endOfQuarter());
        $this->assertEquals($expected, $testDate->endOf('quarter'));

        $expected = new PhpDateTime('2001-12-31 23:59:59+08:00');
        $testDate = $testDate->addMonths(3);

        $this->assertEquals($expected, $testDate->endOfQuarter());
        $this->assertEquals($expected, $testDate->endOf('quarter'));
    }

    public function testStartOfYear()
    {
        $expected = new PhpDateTime('2001-01-01 00:00:00+08:00');
        $testDate = new DateTime(self::TEST_DATE);

        $this->assertEquals($expected, $testDate->startOfYear());
        $this->assertEquals($expected, $testDate->startOf('year'));
    }

    public function testEndOfYear()
    {
        $expected = new PhpDateTime('2001-12-31 23:59:59+08:00');
        $testDate = new DateTime(self::TEST_DATE);

        $this->assertEquals($expected, $testDate->endOfYear());
        $this->assertEquals($expected, $testDate->endOf('year'));
    }

    public function testStartOfMethodIsCaseInsensitive()
    {
        $testDate = new DateTime();
        $expected = $testDate->startOfYear();

        $this->assertEquals($expected, $testDate->startOf('YEAR'));
        $this->assertEquals($expected, $testDate->startOf('Year'));
        $this->assertEquals($expected, $testDate->startOf('YeAr'));
    }

    public function testEndOfMethodIsCaseInsensitive()
    {
        $testDate = new DateTime();
        $expected = $testDate->endOfYear();

        $this->assertEquals($expected, $testDate->endOf('YEAR'));
        $this->assertEquals($expected, $testDate->endOf('Year'));
        $this->assertEquals($expected, $testDate->endOf('YeAr'));
    }
}
