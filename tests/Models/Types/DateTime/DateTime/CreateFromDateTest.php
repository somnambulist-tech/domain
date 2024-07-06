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
class CreateFromDateTest extends TestCase
{
    use Helpers;

    public function testCreateFromDateWithDefaults()
    {
        $d = DateTime::now();
        $this->assertSame($d->timestamp(), DateTime::create()->timestamp());
    }

    public function testCreateFromDate()
    {
        $d = DateTime::createFromDate(1975, 5, 21);
        $this->assertDateTime($d, 1975, 5, 21);
    }

    public function testCreateFromDateWithYear()
    {
        $d = DateTime::createFromDate(1975, 1, 1);
        $this->assertSame(1975, $d->year());
    }

    public function testCreateFromDateWithMonth()
    {
        $d = DateTime::createFromDate(2020, 5, 1);
        $this->assertSame(5, $d->month());
    }

    public function testCreateFromDateWithDay()
    {
        $d = DateTime::createFromDate(2020, 5, 21);
        $this->assertSame(21, $d->day());
    }

    public function testCreateFromDateWithTimezone()
    {
        $d = DateTime::createFromDate(1975, 5, 21, new TimeZone('Europe/London'));
        $this->assertDateTime($d, 1975, 5, 21);
        $this->assertSame('Europe/London', (string)$d->timezone());
    }

    public function testCreateFromDateWithDateTimeZone()
    {
        $d = DateTime::createFromDate(1975, 5, 21, new TimeZone('Europe/London'));
        $this->assertDateTime($d, 1975, 5, 21);
        $this->assertSame('Europe/London', (string)$d->timezone());
    }
}
