<?php

namespace Somnambulist\Domain\Tests\Entities\Types\DateTime\DateTime;

use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Entities\Types\DateTime\DateTime;
use Somnambulist\Domain\Tests\Entities\Types\DateTime\Helpers;

/**
 * Class IsTest
 *
 * @package    Somnambulist\Domain\Tests\Entities\Types\DateTime\DateTime
 * @subpackage Somnambulist\Domain\Tests\Entities\Types\DateTime\DateTime\IsTest
 */
class IsTest extends TestCase
{

    use Helpers;

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsYesterdayTrue()
    {
        $this->assertTrue(DateTime::now()->modify('-1 day')->isYesterday());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsYesterdayFalseWithToday()
    {
        $this->assertFalse(DateTime::now()->modify('midnight')->isYesterday());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsYesterdayFalseWith2Days()
    {
        $this->assertFalse(DateTime::now()->modify('-2 days midnight')->isYesterday());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsTodayTrue()
    {
        $this->assertTrue(DateTime::now()->isToday());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsNextWeekTrue()
    {
        $this->assertTrue(DateTime::now()->modify('+1 week')->isNextWeek());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsLastWeekTrue()
    {
        $this->assertTrue(DateTime::now()->modify('-1 week')->isLastWeek());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsNextWeekFalse()
    {
        $this->assertFalse(DateTime::now()->modify('+2 weeks')->isNextWeek());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsLastWeekFalse()
    {
        $this->assertFalse(DateTime::now()->modify('-2 weeks')->isLastWeek());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsNextMonthTrue()
    {
        $this->assertTrue(DateTime::now()->modify('+1 month')->isNextMonth());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsLastMonthTrue()
    {
        $this->assertTrue(DateTime::now()->modify('-1 month')->isLastMonth());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsNextMonthFalse()
    {
        $this->assertFalse(DateTime::now()->modify('-2 months')->isNextMonth());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsLastMonthFalse()
    {
        $this->assertFalse(DateTime::now()->modify('-2 months')->isLastMonth());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsNextYearTrue()
    {
        $this->assertTrue(DateTime::now()->modify('+1 year')->isNextYear());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsLastYearTrue()
    {
        $this->assertTrue(DateTime::now()->modify('-1 year')->isLastYear());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsNextYearFalse()
    {
        $this->assertFalse(DateTime::now()->modify('+2 year')->isNextYear());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsLastYearFalse()
    {
        $this->assertFalse(DateTime::now()->modify('-2 year')->isLastYear());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsTodayFalseWithYesterday()
    {
        $this->assertFalse(DateTime::now()->modify('-1 day midnight')->isToday());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsTodayFalseWithTomorrow()
    {
        $this->assertFalse(DateTime::now()->modify('+1 day midnight')->isToday());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsTodayWithTimezone()
    {
        $this->assertTrue(DateTime::now('Asia/Tokyo')->isToday());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsTomorrowTrue()
    {
        $this->assertTrue(DateTime::now()->modify('+1 day')->isTomorrow());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsTomorrowFalseWithToday()
    {
        $this->assertFalse(DateTime::now()->modify('midnight')->isTomorrow());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsTomorrowFalseWith2Days()
    {
        $this->assertFalse(DateTime::now()->modify('+2 days midnight')->isTomorrow());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsFutureTrue()
    {
        $this->assertTrue(DateTime::now()->modify('+1 second')->isFuture());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsFutureFalse()
    {
        $this->assertFalse(DateTime::now()->isFuture());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsFutureFalseInThePast()
    {
        $this->assertFalse(DateTime::now()->modify('-1 second')->isFuture());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsPastTrue()
    {
        $this->assertTrue(DateTime::now()->modify('-1 second')->isPast());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsPastFalse()
    {
        $this->assertFalse(DateTime::now()->modify('+1 second')->isPast());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testNowIsPastFalse()
    {
        if (version_compare(PHP_VERSION, '7.1.0', '>=')) {
            $this->markTestSkipped();
        }
        $this->assertFalse(DateTime::now()->isPast());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsLeapYearTrue()
    {
        $this->assertTrue(DateTime::createFromDate(2016, 1, 1)->isLeapYear());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsLeapYearFalse()
    {
        $this->assertFalse(DateTime::createFromDate(2014, 1, 1)->isLeapYear());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsLongYear()
    {
        $this->assertTrue(DateTime::createFromDate(2009, 1, 3)->isLongYear());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsLongYearFalse()
    {
        $this->assertFalse(DateTime::createFromDate(2010, 1, 3)->isLongYear());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsCurrentYearTrue()
    {
        $this->assertTrue(DateTime::now()->isCurrentYear());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsCurrentYearFalse()
    {
        $this->assertFalse(DateTime::now()->modify('-1 year')->isCurrentYear());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsSameYearTrue()
    {
        $this->assertTrue(DateTime::now()->isSameYear(DateTime::now()));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsSameYearFalse()
    {
        $this->assertFalse(DateTime::now()->isSameYear(DateTime::now()->modify('-1 year')));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsCurrentMonthTrue()
    {
        $this->assertTrue(DateTime::now()->isCurrentMonth());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsCurrentMonthFalse()
    {
        $this->assertFalse(DateTime::now()->modify('-1 month')->isCurrentMonth());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsSameMonthTrue()
    {
        $this->assertTrue(DateTime::now()->isSameMonth(DateTime::now()));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsSameMonthFalse()
    {
        $this->assertFalse(DateTime::now()->isSameMonth(DateTime::now()->modify('-1 month')));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsSameMonthAndYearTrue()
    {
        $this->assertTrue(DateTime::now()->isSameMonth(DateTime::now(), true));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsSameMonthAndYearFalse()
    {
        $this->assertFalse(DateTime::now()->isSameMonth(DateTime::now()->modify('-1 year'), true));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsSameDayTrue()
    {
        $current = DateTime::createFromDate(2012, 1, 2);
        $this->assertTrue($current->isSameDay(DateTime::createFromDate(2012, 1, 2)));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testIsSameDayFalse()
    {
        $current = DateTime::createFromDate(2012, 1, 2);
        $this->assertFalse($current->isSameDay(DateTime::createFromDate(2012, 1, 3)));
    }
}
