<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Models\Types\DateTime;

use Somnambulist\Components\Models\Types\DateTime\DateTime;

trait Helpers
{
    protected function setUp(): void
    {
        date_default_timezone_set('America/Toronto');
    }

    protected function assertDateTime(DateTime $d, $year, $month, $day, $hour = null, $minute = null, $second = null): void
    {
        $actual   = [
            'years'  => $year,
            'months' => $month,
            'day'    => $day,
        ];
        $expected = [
            'years'  => $d->year(),
            'months' => $d->month(),
            'day'    => $d->day(),
        ];
        if ($hour !== null) {
            $expected['hours'] = $d->hour();
            $actual['hours']   = $hour;
        }
        if ($minute !== null) {
            $expected['minutes'] = $d->minute();
            $actual['minutes']   = $minute;
        }
        if ($second !== null) {
            $expected['seconds'] = $d->second();
            $actual['seconds']   = $second;
        }
        $this->assertSame($expected, $actual);
    }

    protected function assertInstanceOfDateTime($d): void
    {
        $this->assertInstanceOf(DateTime::class, $d);
    }
}
