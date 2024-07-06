<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Models\Types\DateTime\DateTime;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\DateTime\DateTime;
use Somnambulist\Components\Models\Types\DateTime\TimeZone;
use Somnambulist\Components\Tests\Models\Types\DateTime\Helpers;

#[Group('models')]
#[Group('models-types')]
#[Group('models-types-datetime')]
class ComparableTest extends TestCase
{
    use Helpers;

    public function testEqualToTrue()
    {
        $this->assertTrue(DateTime::createFromDate(2000, 1, 1)->eq(DateTime::createFromDate(2000, 1, 1)));
    }

    public function testEqualToFalse()
    {
        $this->assertFalse(DateTime::createFromDate(2000, 1, 1)->eq(DateTime::createFromDate(2000, 1, 2)));
    }

    public function testEqualWithTimezoneTrue()
    {
        $this->assertTrue(DateTime::create(2000, 1, 1, 12, 0, 0, new TimeZone('America/Toronto'))
            ->eq(DateTime::create(2000, 1, 1, 9, 0, 0, new TimeZone('America/Vancouver'))));
    }

    public function testEqualWithTimezoneFalse()
    {
        $this->assertFalse(DateTime::createFromDate(2000, 1, 1, new TimeZone('America/Toronto'))
            ->eq(DateTime::createFromDate(2000, 1, 1, new TimeZone('America/Vancouver'))));
    }

    public function testNotEqualToTrue()
    {
        $this->assertTrue(DateTime::createFromDate(2000, 1, 1)->ne(DateTime::createFromDate(2000, 1, 2)));
    }

    public function testNotEqualToFalse()
    {
        $this->assertFalse(DateTime::createFromDate(2000, 1, 1)->notEqualTo(DateTime::createFromDate(2000, 1, 1)));
    }

    public function testNotEqualWithTimezone()
    {
        $this->assertTrue(DateTime::createFromDate(2000, 1, 1, new TimeZone('America/Toronto'))
            ->ne(DateTime::createFromDate(2000, 1, 1, new TimeZone('America/Vancouver'))));
    }

    public function testGreaterThanTrue()
    {
        $this->assertTrue(DateTime::createFromDate(2000, 1, 1)->gt(DateTime::createFromDate(1999, 12, 31)));
    }

    public function testGreaterThanFalse()
    {
        $this->assertFalse(DateTime::createFromDate(2000, 1, 1)->greaterThan(DateTime::createFromDate(2000, 1, 2)));
    }

    public function testGreaterThanWithTimezoneTrue()
    {
        $dt1 = DateTime::create(2000, 1, 1, 12, 0, 0, new TimeZone('America/Toronto'));
        $dt2 = DateTime::create(2000, 1, 1, 8, 59, 59, new TimeZone('America/Vancouver'));
        $this->assertTrue($dt1->gt($dt2));
    }

    public function testGreaterThanWithTimezoneFalse()
    {
        $dt1 = DateTime::create(2000, 1, 1, 12, 0, 0, new TimeZone('America/Toronto'));
        $dt2 = DateTime::create(2000, 1, 1, 9, 0, 1, new TimeZone('America/Vancouver'));
        $this->assertFalse($dt1->gt($dt2));
    }

    public function testGreaterThanOrEqualTrue()
    {
        $this->assertTrue(DateTime::createFromDate(2000, 1, 1)->gte(DateTime::createFromDate(1999, 12, 31)));
    }

    public function testGreaterThanOrEqualTrueEqual()
    {
        $this->assertTrue(DateTime::createFromDate(2000, 1, 1)->greaterThanOrEqualTo(DateTime::createFromDate(2000, 1, 1)));
    }

    public function testGreaterThanOrEqualFalse()
    {
        $this->assertFalse(DateTime::createFromDate(2000, 1, 1)->gte(DateTime::createFromDate(2000, 1, 2)));
    }

    public function testLessThanTrue()
    {
        $this->assertTrue(DateTime::createFromDate(2000, 1, 1)->lt(DateTime::createFromDate(2000, 1, 2)));
    }

    public function testLessThanFalse()
    {
        $this->assertFalse(DateTime::createFromDate(2000, 1, 1)->lessThan(DateTime::createFromDate(1999, 12, 31)));
    }

    public function testLessThanOrEqualTrue()
    {
        $this->assertTrue(DateTime::createFromDate(2000, 1, 1)->lte(DateTime::createFromDate(2000, 1, 2)));
    }

    public function testLessThanOrEqualTrueEqual()
    {
        $this->assertTrue(DateTime::createFromDate(2000, 1, 1)->lessThanOrEqualTo(DateTime::createFromDate(2000, 1, 1)));
    }

    public function testLessThanOrEqualFalse()
    {
        $this->assertFalse(DateTime::createFromDate(2000, 1, 1)->lte(DateTime::createFromDate(1999, 12, 31)));
    }

    public function testBetweenEqualTrue()
    {
        $this->assertTrue(DateTime::createFromDate(2000, 1, 15)
            ->between(DateTime::createFromDate(2000, 1, 1), DateTime::createFromDate(2000, 1, 31), true));
    }

    public function testBetweenNotEqualTrue()
    {
        $this->assertTrue(DateTime::createFromDate(2000, 1, 15)
            ->between(DateTime::createFromDate(2000, 1, 1), DateTime::createFromDate(2000, 1, 31), false));
    }

    public function testBetweenEqualFalse()
    {
        $this->assertFalse(DateTime::createFromDate(1999, 12, 31)
            ->between(DateTime::createFromDate(2000, 1, 1), DateTime::createFromDate(2000, 1, 31), true));
    }

    public function testBetweenNotEqualFalse()
    {
        $this->assertFalse(DateTime::createFromDate(2000, 1, 1)
            ->between(DateTime::createFromDate(2000, 1, 1), DateTime::createFromDate(2000, 1, 31), false));
    }

    public function testBetweenEqualSwitchTrue()
    {
        $this->assertTrue(DateTime::createFromDate(2000, 1, 15)
            ->between(DateTime::createFromDate(2000, 1, 31), DateTime::createFromDate(2000, 1, 1), true));
    }

    public function testBetweenNotEqualSwitchTrue()
    {
        $this->assertTrue(DateTime::createFromDate(2000, 1, 15)
            ->between(DateTime::createFromDate(2000, 1, 31), DateTime::createFromDate(2000, 1, 1), false));
    }

    public function testBetweenEqualSwitchFalse()
    {
        $this->assertFalse(DateTime::createFromDate(1999, 12, 31)
            ->between(DateTime::createFromDate(2000, 1, 31), DateTime::createFromDate(2000, 1, 1), true));
    }

    public function testBetweenNotEqualSwitchFalse()
    {
        $this->assertFalse(DateTime::createFromDate(2000, 1, 1)
            ->between(DateTime::createFromDate(2000, 1, 31), DateTime::createFromDate(2000, 1, 1), false));
    }

    public function testMinIsFluid()
    {
        $dt = DateTime::now();
        $this->assertInstanceOfDateTime($dt->min());
    }

    public function testMinWithNow()
    {
        $dt = DateTime::create(2012, 1, 1, 0, 0, 0)->min();
        $this->assertDateTime($dt, 2012, 1, 1, 0, 0, 0);
    }

    public function testMinWithInstance()
    {
        $dt1 = DateTime::create(2013, 12, 31, 23, 59, 59);
        $dt2 = DateTime::create(2012, 1, 1, 0, 0, 0)->minimum($dt1);
        $this->assertDateTime($dt2, 2012, 1, 1, 0, 0, 0);
    }

    public function testMaxIsFluid()
    {
        $dt = DateTime::now();
        $this->assertInstanceOfDateTime($dt->max());
    }

    public function testMaxWithNow()
    {
        $dt = DateTime::create(2099, 12, 31, 23, 59, 59)->maximum();
        $this->assertDateTime($dt, 2099, 12, 31, 23, 59, 59);
    }

    public function testMaxWithInstance()
    {
        $dt1 = DateTime::create(2012, 1, 1, 0, 0, 0);
        $dt2 = DateTime::create(2099, 12, 31, 23, 59, 59)->max($dt1);
        $this->assertDateTime($dt2, 2099, 12, 31, 23, 59, 59);
    }
}
