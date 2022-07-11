<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types\DateTime;

use Somnambulist\Components\Models\Types\DateTime\DateFormat as F;

final class DateFormatBuilder
{
    private array $format = [];

    public static function create(): self
    {
        return new self;
    }

    /**
     * Add an arbitrary string to the format, defaults to a space
     *
     * Note: special characters must be escaped
     */
    public function then(string $string = F::SPACE): self
    {
        $this->format[] = $string;

        return $this;
    }

    public function get(): DateFormat
    {
        return new DateFormat(implode('', $this->format));
    }

    public function space(): self
    {
        return $this->then();
    }

    public function date(string $separator = '-'): self
    {
        return $this->year()->then($separator)->month()->then($separator)->day();
    }

    public function time(string $separator = ':'): self
    {
        return $this->hours()->then($separator)->minutes()->then($separator)->seconds();
    }

    public function year(bool $full = true): self
    {
        return $this->then($full ? F::YEAR : F::YEAR_SHORT);
    }

    public function isLeapYear(): self
    {
        return $this->then(F::YEAR_IS_LEAP);
    }

    public function month(bool $withZero = true): self
    {
        return $this->then($withZero ? F::MONTH : F::MONTH_NUM);
    }

    public function monthName(bool $full = true): self
    {
        return $this->then($full ? F::MONTH_FULL : F::MONTH_SHORT);
    }

    public function day(bool $withZero = true): self
    {
        return $this->then($withZero ? F::DAY : F::DAY_NUM);
    }

    public function dayName(bool $full = true): self
    {
        return $this->then($full ? F::DAY_FULL : F::DAY_SHORT);
    }

    public function daySuffix(): self
    {
        return $this->then(F::DAY_SUFFIX);
    }

    public function dayOfTheWeek(): self
    {
        return $this->then(F::DAY_OF_WEEK);
    }

    public function dayOfTheYear(): self
    {
        return $this->then(F::DAY_OF_YEAR);
    }

    public function daysInTheMonth(): self
    {
        return $this->then(F::DAYS_IN_MONTH);
    }

    public function weekNumber(): self
    {
        return $this->then(F::WEEK);
    }

    public function hours(bool $use24hour = true, bool $withZero = true): self
    {
        return $this->then($use24hour ? ($withZero ? F::HOUR_24 : F::HOUR_24_NUM) : ($withZero ? F::HOUR_12 : F::HOUR_12_NUM));
    }

    public function minutes(): self
    {
        return $this->then(F::MINUTES);
    }

    public function seconds(): self
    {
        return $this->then(F::SECONDS);
    }

    public function amOrPm(bool $uppercase = true): self
    {
        return $this->then($uppercase ? F::MERIDIEM_UPPER : F::MERIDIEM_LOWER);
    }

    public function timezone(bool $abbr = false): self
    {
        return $this->then($abbr ? F::TIMEZONE_ABBR : F::TIMEZONE);
    }

    public function timezoneCapital(): self
    {
        return $this->then(F::TIMEZONE_CAPITAL);
    }

    public function timezoneOffset(): self
    {
        return $this->then(F::TIMEZONE_OFFSET);
    }

    public function timezoneGMTOffset(bool $separated = true): self
    {
        return $this->then($separated ? F::DIFF_TO_GMT_SEPARATED : F::DIFF_TO_GMT);
    }
}
