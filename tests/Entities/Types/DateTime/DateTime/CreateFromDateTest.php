<?php

namespace Somnambulist\Domain\Tests\Entities\Types\DateTime\DateTime;

use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Entities\Types\DateTime\DateTime;
use Somnambulist\Domain\Entities\Types\DateTime\TimeZone;
use Somnambulist\Domain\Tests\Entities\Types\DateTime\Helpers;

/**
 * Class CreateFromDateTest
 *
 * @package    Somnambulist\Domain\Tests\Entities\Types\DateTime\DateTime
 * @subpackage Somnambulist\Domain\Tests\Entities\Types\DateTime\DateTime\CreateFromDateTest
 */
class CreateFromDateTest extends TestCase
{

    use Helpers;

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testCreateFromDateWithDefaults()
    {
        $d = DateTime::createFromDate();
        $this->assertSame($d->timestamp(), DateTime::create(null, null, null, null, null, null)->timestamp());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testCreateFromDate()
    {
        $d = DateTime::createFromDate(1975, 5, 21);
        $this->assertDateTime($d, 1975, 5, 21);
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testCreateFromDateWithYear()
    {
        $d = DateTime::createFromDate(1975);
        $this->assertSame(1975, $d->year());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testCreateFromDateWithMonth()
    {
        $d = DateTime::createFromDate(null, 5);
        $this->assertSame(5, $d->month());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testCreateFromDateWithDay()
    {
        $d = DateTime::createFromDate(null, null, 21);
        $this->assertSame(21, $d->day());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testCreateFromDateWithTimezone()
    {
        $d = DateTime::createFromDate(1975, 5, 21, new TimeZone('Europe/London'));
        $this->assertDateTime($d, 1975, 5, 21);
        $this->assertSame('Europe/London', (string)$d->timezone());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testCreateFromDateWithDateTimeZone()
    {
        $d = DateTime::createFromDate(1975, 5, 21, new TimeZone('Europe/London'));
        $this->assertDateTime($d, 1975, 5, 21);
        $this->assertSame('Europe/London', (string)$d->timezone());
    }
}
