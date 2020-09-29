<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Entities\Types\DateTime\DateTime;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Domain\Entities\Types\DateTime\DateTime;
use Somnambulist\Components\Domain\Tests\Entities\Types\DateTime\Helpers;

/**
 * Class ModifiersTest
 *
 * @package    Somnambulist\Components\Domain\Tests\Entities\Types\DateTime\DateTime
 * @subpackage Somnambulist\Components\Domain\Tests\Entities\Types\DateTime\DateTime\ModifiersTest
 *
 * @group entities
 * @group entities-types
 * @group entities-types-datetime
 */
class SubTest extends TestCase
{

    use Helpers;

    public function testSubYearsPositive()
    {
        $this->assertSame(1974, DateTime::createFromDate(1975, 1, 1)->subYears(1)->year());
    }

    public function testSubYearsZero()
    {
        $this->assertSame(1975, DateTime::createFromDate(1975, 1, 1)->subYears(0)->year());
    }

    public function testSubYearsNegative()
    {
        $this->assertSame(1976, DateTime::createFromDate(1975, 1, 1)->subYears(-1)->year());
    }

    public function testSubMonthsPositive()
    {
        $this->assertSame(12, DateTime::createFromDate(1975, 1, 1)->subMonths(1)->month());
    }

    public function testSubMonthsZero()
    {
        $this->assertSame(1, DateTime::createFromDate(1975, 1, 1)->subMonths(0)->month());
    }

    public function testSubMonthsNegative()
    {
        $this->assertSame(2, DateTime::createFromDate(1975, 1, 1)->subMonths(-1)->month());
    }

    public function testSubDaysPositive()
    {
        $this->assertSame(30, DateTime::createFromDate(1975, 5, 1)->subDays(1)->day());
    }

    public function testSubDaysZero()
    {
        $this->assertSame(1, DateTime::createFromDate(1975, 5, 1)->subDays(0)->day());
    }

    public function testSubDaysNegative()
    {
        $this->assertSame(2, DateTime::createFromDate(1975, 5, 1)->subDays(-1)->day());
    }

    public function testSubWeeksPositive()
    {
        $this->assertSame(14, DateTime::createFromDate(1975, 5, 21)->subWeeks(1)->day());
    }

    public function testSubWeeksZero()
    {
        $this->assertSame(21, DateTime::createFromDate(1975, 5, 21)->subWeeks(0)->day());
    }

    public function testSubWeeksNegative()
    {
        $this->assertSame(28, DateTime::createFromDate(1975, 5, 21)->subWeeks(-1)->day());
    }

    public function testSubHoursPositive()
    {
        $this->assertSame(23, DateTime::createFromTime(0, 0, 0)->subHours(1)->hour());
    }

    public function testSubHoursZero()
    {
        $this->assertSame(0, DateTime::createFromTime(0, 0, 0)->subHours(0)->hour());
    }

    public function testSubHoursNegative()
    {
        $this->assertSame(1, DateTime::createFromTime(0, 0, 0)->subHours(-1)->hour());
    }

    public function testSubMinutesPositive()
    {
        $this->assertSame(59, DateTime::createFromTime(0, 0, 0)->subMinutes(1)->minute());
    }

    public function testSubMinutesZero()
    {
        $this->assertSame(0, DateTime::createFromTime(0, 0, 0)->subMinutes(0)->minute());
    }

    public function testSubMinutesNegative()
    {
        $this->assertSame(1, DateTime::createFromTime(0, 0, 0)->subMinutes(-1)->minute());
    }

    public function testSubSecondsPositive()
    {
        $this->assertSame(59, DateTime::createFromTime(0, 0, 0)->subSeconds(1)->second());
    }

    public function testSubSecondsZero()
    {
        $this->assertSame(0, DateTime::createFromTime(0, 0, 0)->subSeconds(0)->second());
    }

    public function testSubSecondsNegative()
    {
        $this->assertSame(1, DateTime::createFromTime(0, 0, 0)->subSeconds(-1)->second());
    }
}
