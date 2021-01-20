<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types\DateTime\Behaviours;

use DateTimeInterface;
use DateTimeZone;
use InvalidArgumentException;
use Somnambulist\Domain\Entities\Types\DateTime\DateTime;
use Somnambulist\Domain\Entities\Types\DateTime\TimeZone;

/**
 * Trait Factory
 *
 * @package    Somnambulist\Domain\Entities\Types\DateTime\Behaviours
 * @subpackage Somnambulist\Domain\Entities\Types\DateTime\Behaviours\Factory
 */
trait Factory
{

    public static function now($tz = null): self
    {
        return static::parse('now', $tz instanceof TimeZone ? $tz : TimeZone::create($tz));
    }

    public static function parse(string $time, TimeZone $tz): self
    {
        return new static($time, $tz->toNative());
    }

    public static function parseUtc(string $time = 'now'): self
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
    public static function create(int $year = null, int $month = null, int $day = null, int $hour = null, int $minute = null, int $second = null, TimeZone $tz = null): self
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

    public static function createUtc(int $year = null, int $month = null, int $day = null, int $hour = null, int $minute = null, int $second = null): self
    {
        return static::create($year, $month, $day, $hour, $minute, $second, TimeZone::utc());
    }

    /**
     * Create a datetime instance from just a date. The time portion is set to now.
     *
     * @param int|null      $year
     * @param int|null      $month
     * @param int|null      $day
     * @param TimeZone|null $tz
     *
     * @return static
     */
    public static function createFromDate(int $year, int $month, int $day, TimeZone $tz = null): self
    {
        return static::create($year, $month, $day, null, null, null, $tz);
    }

    /**
     * Create a datetime instance from just a time. The date portion is set to today.
     *
     * @param int|null      $hour
     * @param int|null      $minute
     * @param int|null      $second
     * @param TimeZone|null $tz
     *
     * @return static
     */
    public static function createFromTime(int $hour, int $minute, int $second, TimeZone $tz = null): self
    {
        return static::create(null, null, null, $hour, $minute, $second, $tz);
    }

    public static function createFromFormat($format, $time, ?DateTimeZone $object = null)
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
