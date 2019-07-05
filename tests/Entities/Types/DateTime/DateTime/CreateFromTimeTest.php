<?php

namespace Somnambulist\Domain\Tests\Entities\Types\DateTime\DateTime;

use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Entities\Types\DateTime\DateTime;
use Somnambulist\Domain\Entities\Types\DateTime\TimeZone;
use Somnambulist\Domain\Tests\Entities\Types\DateTime\Helpers;

/**
 * Class CreateFromTimeTest
 *
 * @package    Somnambulist\Domain\Tests\Entities\Types\DateTime\DateTime
 * @subpackage Somnambulist\Domain\Tests\Entities\Types\DateTime\DateTime\CreateFromTimeTest
 */
class CreateFromTimeTest extends TestCase
{

    use Helpers;

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testCreateFromDateWithDefaults()
    {
        $d = DateTime::createFromTime();
        $this->assertSame($d->timestamp(), DateTime::create(null, null, null, null, null, null)->timestamp());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testCreateFromDate()
    {
        $d = DateTime::createFromTime(23, 5, 21);
        $this->assertDateTime($d, DateTime::now()->year(), DateTime::now()->month(), DateTime::now()->day(), 23, 5, 21);
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testCreateFromTimeWithHour()
    {
        $d = DateTime::createFromTime(22, 0, 0);
        $this->assertSame(22, $d->hour());
        $this->assertSame(0, $d->minute());
        $this->assertSame(0, $d->second());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testCreateFromTimeWithMinute()
    {
        $d = DateTime::createFromTime(null, 5);
        $this->assertSame(5, $d->minute());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testCreateFromTimeWithSecond()
    {
        $d = DateTime::createFromTime(null, null, 21);
        $this->assertSame(21, $d->second());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testCreateFromTimeWithDateTimeZone()
    {
        $d = DateTime::createFromTime(12, 0, 0, new TimeZone('Europe/London'));
        $this->assertDateTime($d, DateTime::now()->year(), DateTime::now()->month(), DateTime::now()->day(), 12, 0, 0);
        $this->assertSame('Europe/London', (string)$d->timezone());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testCreateFromTimeWithTimeZoneString()
    {
        $d = DateTime::createFromTime(12, 0, 0, new TimeZone('Europe/London'));
        $this->assertDateTime($d, DateTime::now()->year(), DateTime::now()->month(), DateTime::now()->day(), 12, 0, 0);
        $this->assertSame('Europe/London', (string)$d->timezone());
    }
}
