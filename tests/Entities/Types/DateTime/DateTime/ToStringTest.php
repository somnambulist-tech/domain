<?php

namespace Somnambulist\Domain\Tests\Entities\Types\DateTime\DateTime;

use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Entities\Types\DateTime\DateTime;
use Somnambulist\Domain\Tests\Entities\Types\DateTime\Helpers;

/**
 * Class ToStringTest
 *
 * @package    Somnambulist\Domain\Tests\Entities\Types\DateTime\DateTime
 * @subpackage Somnambulist\Domain\Tests\Entities\Types\DateTime\DateTime\ToStringTest
 */
class ToStringTest extends TestCase
{

    use Helpers;

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testToDateString()
    {
        $d = DateTime::create(1975, 12, 25, 14, 15, 16);
        $this->assertSame('1975-12-25', $d->toDateString());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testToFormattedDateString()
    {
        $d = DateTime::create(1975, 12, 25, 14, 15, 16);
        $this->assertSame('Dec 25, 1975', $d->toFormattedDateString());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testToTimeString()
    {
        $d = DateTime::create(1975, 12, 25, 14, 15, 16);
        $this->assertSame('14:15:16', $d->toTimeString());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testToDateTimeString()
    {
        $d = DateTime::create(1975, 12, 25, 14, 15, 16);
        $this->assertSame('1975-12-25 14:15:16', $d->toDateTimeString());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testToDateTimeStringWithPaddedZeroes()
    {
        $d = DateTime::create(2000, 5, 2, 4, 3, 4);
        $this->assertSame('2000-05-02 04:03:04', $d->toDateTimeString());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testToDayDateTimeString()
    {
        $d = DateTime::create(1975, 12, 25, 14, 15, 16);
        $this->assertSame('Thu, Dec 25, 1975 2:15 PM', $d->toDayDateTimeString());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testToAtomString()
    {
        $d = DateTime::create(1975, 12, 25, 14, 15, 16);
        $this->assertSame('1975-12-25T14:15:16-05:00', $d->toAtomString());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testToCOOKIEString()
    {
        $d = DateTime::create(1975, 12, 25, 14, 15, 16);
        if (\DateTime::COOKIE === 'l, d-M-y H:i:s T') {
            $cookieString = 'Thursday, 25-Dec-75 14:15:16 EST';
        } else {
            $cookieString = 'Thursday, 25-Dec-1975 14:15:16 EST';
        }
        $this->assertSame($cookieString, $d->toCookieString());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testToIso8601String()
    {
        $d = DateTime::create(1975, 12, 25, 14, 15, 16);
        $this->assertSame('1975-12-25T14:15:16-05:00', $d->toIso8601String());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testToRC822String()
    {
        $d = DateTime::create(1975, 12, 25, 14, 15, 16);
        $this->assertSame('Thu, 25 Dec 75 14:15:16 -0500', $d->toRfc822String());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testToRfc2822String()
    {
        $d = DateTime::create(1975, 12, 25, 14, 15, 16);
        $this->assertSame('Thu, 25 Dec 1975 14:15:16 -0500', $d->toRfc2822String());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testToRssString()
    {
        $d = DateTime::create(1975, 12, 25, 14, 15, 16);
        $this->assertSame('Thu, 25 Dec 1975 14:15:16 -0500', $d->toRssString());
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testToW3cString()
    {
        $d = DateTime::create(1975, 12, 25, 14, 15, 16);
        $this->assertSame('1975-12-25T14:15:16-05:00', $d->toW3cString());
    }
}
