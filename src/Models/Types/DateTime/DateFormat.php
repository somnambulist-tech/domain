<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types\DateTime;

/**
 * All the various date format characters as constants
 *
 * Makes it easier to create date formatting instructions in a way that can be read.
 * To compose a string with named methods, see {@link DateFormatBuilder}. DateFormats
 * are intentionally read-only.
 */
final class DateFormat
{
    const SPACE = ' ';

    const DAY = 'd';
    const DAY_NUM = 'j';
    const DAY_SHORT = 'D';
    const DAY_FULL = 'l';
    const DAY_OF_WEEK = 'N';
    const DAY_SUFFIX = 'S';
    const DAY_OF_YEAR = 'z';

    const WEEK = 'W';

    const MONTH = 'm';
    const MONTH_NUM = 'n';
    const MONTH_SHORT = 'M';
    const MONTH_FULL = 'F';
    const DAYS_IN_MONTH = 't';

    const YEAR = 'Y';
    const YEAR_IS_LEAP = 'L';
    const YEAR_ISO_WEEK = 'o';
    const YEAR_SHORT = 'y';

    const MERIDIEM_LOWER = 'a';
    const MERIDIEM_UPPER = 'A';
    const SWATCH_TIME = 'B';
    const HOUR_12_NUM = 'g';
    const HOUR_24_NUM = 'G';
    const HOUR_12 = 'h';
    const HOUR_24 = 'H';
    const MINUTES = 'i';
    const SECONDS = 's';
    const MICRO_SECONDS = 'u';
    const MILLI_SECONDS = 'v';

    const TIMEZONE = 'e';
    const TIMEZONE_CAPITAL = 'I';
    const DIFF_TO_GMT = 'O';
    const DIFF_TO_GMT_SEPARATED = 'P';
    const DIFF_TO_GMT_SEPARATED_Z = 'p';
    const TIMEZONE_ABBR = 'T';
    const TIMEZONE_OFFSET = 'Z';

    const ISO_8601 = 'c';
    const RFC_2822 = 'r';
    const UNIX = 'U';

    public function __construct(private readonly string $format)
    {
    }

    public function __toString(): string
    {
        return $this->format;
    }

    public static function with(string ...$format): self
    {
        return new self(implode('', $format));
    }

    public function format(): string
    {
        return $this->format;
    }

    public function __set(string $name, $value): void
    {
    }

    public function __unset(string $name): void
    {
    }
}
