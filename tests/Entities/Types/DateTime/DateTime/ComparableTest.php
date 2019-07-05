<?php

namespace Somnambulist\Domain\Tests\Entities\Types\DateTime\DateTime;

use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Entities\Types\DateTime\DateTime;
use Somnambulist\Domain\Entities\Types\DateTime\TimeZone;
use Somnambulist\Domain\Tests\Entities\Types\DateTime\Helpers;

/**
 * Class ComparableTest
 *
 * @package    Somnambulist\Domain\Tests\Entities\Types\DateTime\DateTime
 * @subpackage Somnambulist\Domain\Tests\Entities\Types\DateTime\DateTime\ComparableTest
 */
class ComparableTest extends TestCase
{

    use Helpers;

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testEqualToTrue()
    {
        $this->assertTrue(DateTime::createFromDate(2000, 1, 1)->eq(DateTime::createFromDate(2000, 1, 1)));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testEqualToFalse()
    {
        $this->assertFalse(DateTime::createFromDate(2000, 1, 1)->eq(DateTime::createFromDate(2000, 1, 2)));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testEqualWithTimezoneTrue()
    {
        $this->assertTrue(DateTime::create(2000, 1, 1, 12, 0, 0, new TimeZone('America/Toronto'))
            ->eq(DateTime::create(2000, 1, 1, 9, 0, 0, new TimeZone('America/Vancouver'))));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testEqualWithTimezoneFalse()
    {
        $this->assertFalse(DateTime::createFromDate(2000, 1, 1, new TimeZone('America/Toronto'))
            ->eq(DateTime::createFromDate(2000, 1, 1, new TimeZone('America/Vancouver'))));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testNotEqualToTrue()
    {
        $this->assertTrue(DateTime::createFromDate(2000, 1, 1)->ne(DateTime::createFromDate(2000, 1, 2)));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testNotEqualToFalse()
    {
        $this->assertFalse(DateTime::createFromDate(2000, 1, 1)->notEqualTo(DateTime::createFromDate(2000, 1, 1)));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testNotEqualWithTimezone()
    {
        $this->assertTrue(DateTime::createFromDate(2000, 1, 1, new TimeZone('America/Toronto'))
            ->ne(DateTime::createFromDate(2000, 1, 1, new TimeZone('America/Vancouver'))));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testGreaterThanTrue()
    {
        $this->assertTrue(DateTime::createFromDate(2000, 1, 1)->gt(DateTime::createFromDate(1999, 12, 31)));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testGreaterThanFalse()
    {
        $this->assertFalse(DateTime::createFromDate(2000, 1, 1)->greaterThan(DateTime::createFromDate(2000, 1, 2)));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testGreaterThanWithTimezoneTrue()
    {
        $dt1 = DateTime::create(2000, 1, 1, 12, 0, 0, new TimeZone('America/Toronto'));
        $dt2 = DateTime::create(2000, 1, 1, 8, 59, 59, new TimeZone('America/Vancouver'));
        $this->assertTrue($dt1->gt($dt2));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testGreaterThanWithTimezoneFalse()
    {
        $dt1 = DateTime::create(2000, 1, 1, 12, 0, 0, new TimeZone('America/Toronto'));
        $dt2 = DateTime::create(2000, 1, 1, 9, 0, 1, new TimeZone('America/Vancouver'));
        $this->assertFalse($dt1->gt($dt2));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testGreaterThanOrEqualTrue()
    {
        $this->assertTrue(DateTime::createFromDate(2000, 1, 1)->gte(DateTime::createFromDate(1999, 12, 31)));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testGreaterThanOrEqualTrueEqual()
    {
        $this->assertTrue(DateTime::createFromDate(2000, 1, 1)->greaterThanOrEqualTo(DateTime::createFromDate(2000, 1, 1)));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testGreaterThanOrEqualFalse()
    {
        $this->assertFalse(DateTime::createFromDate(2000, 1, 1)->gte(DateTime::createFromDate(2000, 1, 2)));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testLessThanTrue()
    {
        $this->assertTrue(DateTime::createFromDate(2000, 1, 1)->lt(DateTime::createFromDate(2000, 1, 2)));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testLessThanFalse()
    {
        $this->assertFalse(DateTime::createFromDate(2000, 1, 1)->lessThan(DateTime::createFromDate(1999, 12, 31)));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testLessThanOrEqualTrue()
    {
        $this->assertTrue(DateTime::createFromDate(2000, 1, 1)->lte(DateTime::createFromDate(2000, 1, 2)));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testLessThanOrEqualTrueEqual()
    {
        $this->assertTrue(DateTime::createFromDate(2000, 1, 1)->lessThanOrEqualTo(DateTime::createFromDate(2000, 1, 1)));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testLessThanOrEqualFalse()
    {
        $this->assertFalse(DateTime::createFromDate(2000, 1, 1)->lte(DateTime::createFromDate(1999, 12, 31)));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testBetweenEqualTrue()
    {
        $this->assertTrue(DateTime::createFromDate(2000, 1, 15)
            ->between(DateTime::createFromDate(2000, 1, 1), DateTime::createFromDate(2000, 1, 31), true));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testBetweenNotEqualTrue()
    {
        $this->assertTrue(DateTime::createFromDate(2000, 1, 15)
            ->between(DateTime::createFromDate(2000, 1, 1), DateTime::createFromDate(2000, 1, 31), false));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testBetweenEqualFalse()
    {
        $this->assertFalse(DateTime::createFromDate(1999, 12, 31)
            ->between(DateTime::createFromDate(2000, 1, 1), DateTime::createFromDate(2000, 1, 31), true));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testBetweenNotEqualFalse()
    {
        $this->assertFalse(DateTime::createFromDate(2000, 1, 1)
            ->between(DateTime::createFromDate(2000, 1, 1), DateTime::createFromDate(2000, 1, 31), false));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testBetweenEqualSwitchTrue()
    {
        $this->assertTrue(DateTime::createFromDate(2000, 1, 15)
            ->between(DateTime::createFromDate(2000, 1, 31), DateTime::createFromDate(2000, 1, 1), true));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testBetweenNotEqualSwitchTrue()
    {
        $this->assertTrue(DateTime::createFromDate(2000, 1, 15)
            ->between(DateTime::createFromDate(2000, 1, 31), DateTime::createFromDate(2000, 1, 1), false));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testBetweenEqualSwitchFalse()
    {
        $this->assertFalse(DateTime::createFromDate(1999, 12, 31)
            ->between(DateTime::createFromDate(2000, 1, 31), DateTime::createFromDate(2000, 1, 1), true));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testBetweenNotEqualSwitchFalse()
    {
        $this->assertFalse(DateTime::createFromDate(2000, 1, 1)
            ->between(DateTime::createFromDate(2000, 1, 31), DateTime::createFromDate(2000, 1, 1), false));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testMinIsFluid()
    {
        $dt = DateTime::now();
        $this->assertInstanceOfDateTime($dt->min());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testMinWithNow()
    {
        $dt = DateTime::create(2012, 1, 1, 0, 0, 0)->min();
        $this->assertDateTime($dt, 2012, 1, 1, 0, 0, 0);
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testMinWithInstance()
    {
        $dt1 = DateTime::create(2013, 12, 31, 23, 59, 59);
        $dt2 = DateTime::create(2012, 1, 1, 0, 0, 0)->minimum($dt1);
        $this->assertDateTime($dt2, 2012, 1, 1, 0, 0, 0);
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testMaxIsFluid()
    {
        $dt = DateTime::now();
        $this->assertInstanceOfDateTime($dt->max());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testMaxWithNow()
    {
        $dt = DateTime::create(2099, 12, 31, 23, 59, 59)->maximum();
        $this->assertDateTime($dt, 2099, 12, 31, 23, 59, 59);
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testMaxWithInstance()
    {
        $dt1 = DateTime::create(2012, 1, 1, 0, 0, 0);
        $dt2 = DateTime::create(2099, 12, 31, 23, 59, 59)->max($dt1);
        $this->assertDateTime($dt2, 2099, 12, 31, 23, 59, 59);
    }
}
