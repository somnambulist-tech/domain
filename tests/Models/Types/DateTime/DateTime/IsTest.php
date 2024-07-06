<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Models\Types\DateTime\DateTime;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\DateTime\DateTime;
use Somnambulist\Components\Tests\Models\Types\DateTime\Helpers;

#[Group('models')]
#[Group('models-types')]
#[Group('models-types-datetime')]
class IsTest extends TestCase
{
    use Helpers;

    public function testIsYesterdayTrue()
    {
        $this->assertTrue(DateTime::now()->modify('-1 day')->isYesterday());
    }

    public function testIsYesterdayFalseWithToday()
    {
        $this->assertFalse(DateTime::now()->modify('midnight')->isYesterday());
    }

    public function testIsYesterdayFalseWith2Days()
    {
        $this->assertFalse(DateTime::now()->modify('-2 days midnight')->isYesterday());
    }

    public function testIsTodayTrue()
    {
        $this->assertTrue(DateTime::now()->isToday());
    }

    public function testIsNextWeekTrue()
    {
        $this->assertTrue(DateTime::now()->modify('+1 week')->isNextWeek());
    }

    public function testIsLastWeekTrue()
    {
        $this->assertTrue(DateTime::now()->modify('-1 week')->isLastWeek());
    }

    public function testIsNextWeekFalse()
    {
        $this->assertFalse(DateTime::now()->modify('+2 weeks')->isNextWeek());
    }

    public function testIsLastWeekFalse()
    {
        $this->assertFalse(DateTime::now()->modify('-2 weeks')->isLastWeek());
    }

    public function testIsNextMonthTrue()
    {
        $this->assertTrue(DateTime::now()->modify('+1 month')->isNextMonth());
    }

    public function testIsLastMonthTrue()
    {
        $this->assertTrue(DateTime::now()->modify('-1 month')->isLastMonth());
    }

    public function testIsNextMonthFalse()
    {
        $this->assertFalse(DateTime::now()->modify('-2 months')->isNextMonth());
    }

    public function testIsLastMonthFalse()
    {
        $this->assertFalse(DateTime::now()->modify('-2 months')->isLastMonth());
    }

    public function testIsNextYearTrue()
    {
        $this->assertTrue(DateTime::now()->modify('+1 year')->isNextYear());
    }

    public function testIsLastYearTrue()
    {
        $this->assertTrue(DateTime::now()->modify('-1 year')->isLastYear());
    }

    public function testIsNextYearFalse()
    {
        $this->assertFalse(DateTime::now()->modify('+2 year')->isNextYear());
    }

    public function testIsLastYearFalse()
    {
        $this->assertFalse(DateTime::now()->modify('-2 year')->isLastYear());
    }

    public function testIsTodayFalseWithYesterday()
    {
        $this->assertFalse(DateTime::now()->modify('-1 day midnight')->isToday());
    }

    public function testIsTodayFalseWithTomorrow()
    {
        $this->assertFalse(DateTime::now()->modify('+1 day midnight')->isToday());
    }

    public function testIsTodayWithTimezone()
    {
        $this->assertTrue(DateTime::now('Asia/Tokyo')->isToday());
    }

    public function testIsTomorrowTrue()
    {
        $this->assertTrue(DateTime::now()->modify('+1 day')->isTomorrow());
    }

    public function testIsTomorrowFalseWithToday()
    {
        $this->assertFalse(DateTime::now()->modify('midnight')->isTomorrow());
    }

    public function testIsTomorrowFalseWith2Days()
    {
        $this->assertFalse(DateTime::now()->modify('+2 days midnight')->isTomorrow());
    }

    public function testIsFutureTrue()
    {
        $this->assertTrue(DateTime::now()->modify('+1 second')->isFuture());
    }

    public function testIsFutureFalse()
    {
        $this->assertFalse(DateTime::now()->isFuture());
    }

    public function testIsFutureFalseInThePast()
    {
        $this->assertFalse(DateTime::now()->modify('-1 second')->isFuture());
    }

    public function testIsPastTrue()
    {
        $this->assertTrue(DateTime::now()->modify('-1 second')->isPast());
    }

    public function testIsPastFalse()
    {
        $this->assertFalse(DateTime::now()->modify('+1 second')->isPast());
    }

    public function testIsLeapYearTrue()
    {
        $this->assertTrue(DateTime::createFromDate(2016, 1, 1)->isLeapYear());
    }

    public function testIsLeapYearFalse()
    {
        $this->assertFalse(DateTime::createFromDate(2014, 1, 1)->isLeapYear());
    }

    public function testIsLongYear()
    {
        $this->assertTrue(DateTime::createFromDate(2009, 1, 3)->isLongYear());
    }

    public function testIsLongYearFalse()
    {
        $this->assertFalse(DateTime::createFromDate(2010, 1, 3)->isLongYear());
    }

    public function testIsCurrentYearTrue()
    {
        $this->assertTrue(DateTime::now()->isCurrentYear());
    }

    public function testIsCurrentYearFalse()
    {
        $this->assertFalse(DateTime::now()->modify('-1 year')->isCurrentYear());
    }

    public function testIsSameYearTrue()
    {
        $this->assertTrue(DateTime::now()->isSameYear(DateTime::now()));
    }

    public function testIsSameYearFalse()
    {
        $this->assertFalse(DateTime::now()->isSameYear(DateTime::now()->modify('-1 year')));
    }

    public function testIsCurrentMonthTrue()
    {
        $this->assertTrue(DateTime::now()->isCurrentMonth());
    }

    public function testIsCurrentMonthFalse()
    {
        $this->assertFalse(DateTime::now()->modify('-2 month')->isCurrentMonth());
    }

    public function testIsSameMonthTrue()
    {
        $this->assertTrue(DateTime::now()->isSameMonth(DateTime::now()));
    }

    public function testIsSameMonthFalse()
    {
        $this->assertFalse(DateTime::now()->isSameMonth(DateTime::now()->modify('-2 month')));
    }

    public function testIsSameMonthAndYearTrue()
    {
        $this->assertTrue(DateTime::now()->isSameMonth(DateTime::now(), true));
    }

    public function testIsSameMonthAndYearFalse()
    {
        $this->assertFalse(DateTime::now()->isSameMonth(DateTime::now()->modify('-1 year'), true));
    }

    public function testIsSameDayTrue()
    {
        $current = DateTime::createFromDate(2012, 1, 2);
        $this->assertTrue($current->isSameDay(DateTime::createFromDate(2012, 1, 2)));
    }

    public function testIsSameDayFalse()
    {
        $current = DateTime::createFromDate(2012, 1, 2);
        $this->assertFalse($current->isSameDay(DateTime::createFromDate(2012, 1, 3)));
    }
}
