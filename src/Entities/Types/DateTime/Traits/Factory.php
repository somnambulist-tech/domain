<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types\DateTime\Traits;

use DateTimeInterface;
use DateTimeZone;
use InvalidArgumentException;
use Somnambulist\Domain\Entities\Types\DateTime\DateTime;
use Somnambulist\Domain\Entities\Types\DateTime\TimeZone;

/**
 * Trait Factory
 *
 * @package    Somnambulist\Domain\Entities\Types\DateTime\Traits
 * @subpackage Somnambulist\Domain\Entities\Types\DateTime\Traits\Factory
 */
trait Factory
{

    /**
     * @param null|string $tz
     *
     * @return DateTime
     */
    public static function now($tz = null): self
    {
        return static::parse('now', TimeZone::create(($tz instanceof TimeZone ? (string)$tz : $tz)));
    }

    /**
     * Creates a DateTime instance from the time string and TimeZone
     *
     * @param string   $time Any valid datetime string that can be processed by date()
     * @param TimeZone $tz
     *
     * @return DateTime
     */
    public static function parse($time = 'now', TimeZone $tz): self
    {
        return new static($time, $tz->toNative());
    }

    /**
     * Creates a DateTime instance from the time string in UTC
     *
     * @param string $time Any valid datetime string that can be processed by date()
     *
     * @return DateTime
     */
    public static function parseUtc($time = 'now'): self
    {
        return new static($time, new DateTimeZone('UTC'));
    }

    /**
     * Create a DateTime instance
     *
     * Based on Carbon::create with the following differences:
     *  * if you require an hour, you must specify minutes and seconds as 0 (zero)
     *  * TimeZone should be specified using the value object
     *
     * @param null|int      $year
     * @param null|int      $month
     * @param null|int      $day
     * @param null|int      $hour
     * @param null|int      $minute
     * @param null|int      $second
     * @param null|TimeZone $tz
     *
     * @return bool|DateTime
     */
    public static function create($year = null, $month = null, $day = null, $hour = null, $minute = null, $second = null, TimeZone $tz = null): self
    {
        [$nowYear, $nowMonth, $nowDay, $nowHour, $nowMin, $nowSec] = explode('-', date('Y-n-j-G-i-s', time()));

        $year   = $year ?? $nowYear;
        $month  = $month ?? $nowMonth;
        $day    = $day ?? $nowDay;
        $hour   = $hour ?? $nowHour;
        $minute = $minute ?? $nowMin;
        $second = $second ?? $nowSec;
        $tz     = $tz ?? TimeZone::create();

        return static::createFromFormat(
            'Y-n-j G:i:s',
            sprintf('%s-%s-%s %s:%02s:%02s', $year, $month, $day, $hour, $minute, $second),
            $tz->toNative()
        );
    }

    /**
     * Create a Carbon instance from just a date. The time portion is set to now.
     *
     * @param int|null      $year
     * @param int|null      $month
     * @param int|null      $day
     * @param TimeZone|null $tz
     *
     * @return static
     */
    public static function createFromDate($year = null, $month = null, $day = null, $tz = null): self
    {
        return static::create($year, $month, $day, null, null, null, $tz);
    }

    /**
     * Create a Carbon instance from just a time. The date portion is set to today.
     *
     * @param int|null      $hour
     * @param int|null      $minute
     * @param int|null      $second
     * @param TimeZone|null $tz
     *
     * @return static
     */
    public static function createFromTime($hour = null, $minute = null, $second = null, $tz = null): self
    {
        return static::create(null, null, null, $hour, $minute, $second, $tz);
    }

    /**
     * @param string            $format
     * @param string            $time
     * @param null|DateTimeZone $object
     *
     * @return DateTime
     */
    public static function createFromFormat($format, $time, $object = null): self
    {
        if ($object !== null) {
            $dt = parent::createFromFormat($format, $time, $object);
        } else {
            $dt = parent::createFromFormat($format, $time);
        }

        $lastErrors = parent::getLastErrors();

        if ($dt instanceof DateTimeInterface) {
            return new static($dt->format('Y-m-d H:i:s.u'), $dt->getTimezone());
        }

        throw new InvalidArgumentException(implode(PHP_EOL, $lastErrors['errors']));
    }
}
