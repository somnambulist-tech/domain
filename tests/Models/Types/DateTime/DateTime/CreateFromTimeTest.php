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
class CreateFromTimeTest extends TestCase
{
    use Helpers;

    public function testCreateFromDateWithDefaults()
    {
        $d = DateTime::now();
        $this->assertSame($d->timestamp(), DateTime::create()->timestamp());
    }

    public function testCreateFromDate()
    {
        $d = DateTime::createFromTime(23, 5, 21);
        $this->assertDateTime($d, DateTime::now()->year(), DateTime::now()->month(), DateTime::now()->day(), 23, 5, 21);
    }

    public function testCreateFromTimeWithHour()
    {
        $d = DateTime::createFromTime(22, 0, 0);
        $this->assertSame(22, $d->hour());
        $this->assertSame(0, $d->minute());
        $this->assertSame(0, $d->second());
    }

    public function testCreateFromTimeWithMinute()
    {
        $d = DateTime::createFromTime(0, 5, 0);
        $this->assertSame(5, $d->minute());
    }

    public function testCreateFromTimeWithSecond()
    {
        $d = DateTime::createFromTime(0, 0, 21);
        $this->assertSame(21, $d->second());
    }

    public function testCreateFromTimeWithDateTimeZone()
    {
        $d = DateTime::createFromTime(12, 0, 0, new TimeZone('Europe/London'));
        $this->assertDateTime($d, DateTime::now()->year(), DateTime::now()->month(), DateTime::now()->day(), 12, 0, 0);
        $this->assertSame('Europe/London', (string)$d->timezone());
    }

    public function testCreateFromTimeWithTimeZoneString()
    {
        $d = DateTime::createFromTime(12, 0, 0, new TimeZone('Europe/London'));
        $this->assertDateTime($d, DateTime::now()->year(), DateTime::now()->month(), DateTime::now()->day(), 12, 0, 0);
        $this->assertSame('Europe/London', (string)$d->timezone());
    }
}
