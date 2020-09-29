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
class AddTest extends TestCase
{

    use Helpers;

    public function testAddYearsPositive()
    {
        $this->assertSame(1976, DateTime::createFromDate(1975, 1, 1)->addYears(1)->year());
    }

    public function testAddYearsZero()
    {
        $this->assertSame(1975, DateTime::createFromDate(1975, 1, 1)->addYears(0)->year());
    }

    public function testAddYearsNegative()
    {
        $this->assertSame(1974, DateTime::createFromDate(1975, 1, 1)->addYears(-1)->year());
    }

    public function testAddDaysPositive()
    {
        $this->assertSame(1, DateTime::createFromDate(1975, 5, 31)->addDays(1)->day());
    }

    public function testAddDaysZero()
    {
        $this->assertSame(31, DateTime::createFromDate(1975, 5, 31)->addDays(0)->day());
    }

    public function testAddDaysNegative()
    {
        $this->assertSame(30, DateTime::createFromDate(1975, 5, 31)->addDays(-1)->day());
    }

    public function testAddWeeksPositive()
    {
        $this->assertSame(28, DateTime::createFromDate(1975, 5, 21)->addWeeks(1)->day());
    }

    public function testAddWeeksZero()
    {
        $this->assertSame(21, DateTime::createFromDate(1975, 5, 21)->addWeeks(0)->day());
    }

    public function testAddWeeksNegative()
    {
        $this->assertSame(14, DateTime::createFromDate(1975, 5, 21)->addWeeks(-1)->day());
    }

    public function testAddHoursPositive()
    {
        $this->assertSame(1, DateTime::createFromTime(0, 0, 0)->addHours(1)->hour());
    }

    public function testAddHoursZero()
    {
        $this->assertSame(0, DateTime::createFromTime(0, 0, 0)->addHours(0)->hour());
    }

    public function testAddHoursNegative()
    {
        $this->assertSame(23, DateTime::createFromTime(0, 0, 0)->addHours(-1)->hour());
    }

    public function testAddMinutesPositive()
    {
        $this->assertSame(1, DateTime::createFromTime(0, 0, 0)->addMinutes(1)->minute());
    }

    public function testAddMinutesZero()
    {
        $this->assertSame(0, DateTime::createFromTime(0, 0, 0)->addMinutes(0)->minute());
    }

    public function testAddMinutesNegative()
    {
        $this->assertSame(59, DateTime::createFromTime(0, 0, 0)->addMinutes(-1)->minute());
    }

    public function testAddSecondsPositive()
    {
        $this->assertSame(1, DateTime::createFromTime(0, 0, 0)->addSeconds(1)->second());
    }

    public function testAddSecondsZero()
    {
        $this->assertSame(0, DateTime::createFromTime(0, 0, 0)->addSeconds(0)->second());
    }

    public function testAddSecondsNegative()
    {
        $this->assertSame(59, DateTime::createFromTime(0, 0, 0)->addSeconds(-1)->second());
    }
}
