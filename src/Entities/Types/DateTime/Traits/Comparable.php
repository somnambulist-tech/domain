<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types\DateTime\Traits;

use Somnambulist\Domain\Entities\Types\DateTime\DateTime;

/**
 * Trait Comparable
 *
 * Based on Carbon\Carbon test setup methods.
 *
 * @package    Somnambulist\Domain\Entities\Types\DateTime\Traits
 * @subpackage Somnambulist\Domain\Entities\Types\DateTime\Traits\Comparable
 */
trait Comparable
{

    /**
     * @param mixed $object
     *
     * @return bool
     */
    public function equals($object): bool
    {
        if (get_class($object) !== get_class($this)) {
            return false;
        }

        return $this == $object;
    }

    /**
     * Determines if the instance is equal to another
     *
     * @param DateTime $dt
     *
     * @return bool
     */
    public function eq(DateTime $dt): bool
    {
        return $this->equals($dt);
    }

    /**
     * Determines if the instance is not equal to another
     *
     * @param DateTime $dt
     *
     * @return bool
     */
    public function ne(DateTime $dt): bool
    {
        return !$this->eq($dt);
    }

    /**
     * Determines if the instance is not equal to another
     *
     * @param DateTime $dt
     *
     * @see ne()
     *
     * @return bool
     */
    public function notEqualTo(DateTime $dt): bool
    {
        return $this->ne($dt);
    }

    /**
     * Determines if the instance is greater (after) than another
     *
     * @param DateTime $dt
     *
     * @return bool
     */
    public function gt(DateTime $dt): bool
    {
        return $this > $dt;
    }

    /**
     * Determines if the instance is greater (after) than another
     *
     * @param DateTime $dt
     *
     * @see gt()
     *
     * @return bool
     */
    public function greaterThan(DateTime $dt): bool
    {
        return $this->gt($dt);
    }

    /**
     * Determines if the instance is greater (after) than or equal to another
     *
     * @param DateTime $dt
     *
     * @return bool
     */
    public function gte(DateTime $dt): bool
    {
        return $this >= $dt;
    }

    /**
     * Determines if the instance is greater (after) than or equal to another
     *
     * @param DateTime $dt
     *
     * @see gte()
     *
     * @return bool
     */
    public function greaterThanOrEqualTo(DateTime $dt): bool
    {
        return $this->gte($dt);
    }

    /**
     * Determines if the instance is less (before) than another
     *
     * @param DateTime $dt
     *
     * @return bool
     */
    public function lt(DateTime $dt): bool
    {
        return $this < $dt;
    }

    /**
     * Determines if the instance is less (before) than another
     *
     * @param DateTime $dt
     *
     * @see lt()
     *
     * @return bool
     */
    public function lessThan(DateTime $dt): bool
    {
        return $this->lt($dt);
    }

    /**
     * Determines if the instance is less (before) or equal to another
     *
     * @param DateTime $dt
     *
     * @return bool
     */
    public function lte(DateTime $dt): bool
    {
        return $this <= $dt;
    }

    /**
     * Determines if the instance is less (before) or equal to another
     *
     * @param DateTime $dt
     *
     * @see lte()
     *
     * @return bool
     */
    public function lessThanOrEqualTo(DateTime $dt): bool
    {
        return $this->lte($dt);
    }

    /**
     * Determines if the instance is between two others
     *
     * @param DateTime $dt1
     * @param DateTime $dt2
     * @param bool     $equal Indicates if a > and < comparison should be used or <= or >=
     *
     * @return bool
     */
    public function between(DateTime $dt1, DateTime $dt2, $equal = true): bool
    {
        if ($dt1->gt($dt2)) {
            $temp = $dt1;
            $dt1  = $dt2;
            $dt2  = $temp;
        }

        if ($equal) {
            return $this->gte($dt1) && $this->lte($dt2);
        }

        return $this->gt($dt1) && $this->lt($dt2);
    }

    /**
     * Get the minimum instance between a given instance (default now) and the current instance.
     *
     * @param DateTime|null $dt
     *
     * @return static
     */
    public function min(DateTime $dt = null): self
    {
        $dt = $dt ?: static::now($this->timezone());

        return $this->lt($dt) ? $this : $dt;
    }

    /**
     * Get the minimum instance between a given instance (default now) and the current instance.
     *
     * @param DateTime|null $dt
     *
     * @see min()
     *
     * @return static
     */
    public function minimum(DateTime $dt = null): self
    {
        return $this->min($dt);
    }

    /**
     * Get the maximum instance between a given instance (default now) and the current instance.
     *
     * @param DateTime|null $dt
     *
     * @return static
     */
    public function max(DateTime $dt = null): self
    {
        $dt = $dt ?: static::now($this->timezone());

        return $this->gt($dt) ? $this : $dt;
    }

    /**
     * Get the maximum instance between a given instance (default now) and the current instance.
     *
     * @param DateTime|null $dt
     *
     * @see max()
     *
     * @return static
     */
    public function maximum(DateTime $dt = null): self
    {
        return $this->max($dt);
    }

    /**
     * Determines if the instance is yesterday
     *
     * @return bool
     */
    public function isYesterday(): bool
    {
        return $this->toDateString() === static::parse('-1 day', $this->timezone())->toDateString();
    }

    /**
     * Determines if the instance is today
     *
     * @return bool
     */
    public function isToday(): bool
    {
        return $this->toDateString() === static::now($this->timezone())->toDateString();
    }

    /**
     * Determines if the instance is tomorrow
     *
     * @return bool
     */
    public function isTomorrow(): bool
    {
        return $this->toDateString() === static::parse('+1 day', $this->timezone())->toDateString();
    }

    /**
     * Determines if the instance is within the next week
     *
     * @return bool
     */
    public function isNextWeek(): bool
    {
        return $this->weekOfYear() === static::now($this->timezone())->modify('+1 week')->weekOfYear();
    }

    /**
     * Determines if the instance is within the next month
     *
     * @return bool
     */
    public function isNextMonth(): bool
    {
        return $this->month() === static::now($this->timezone())->modify('+1 month')->month();
    }

    /**
     * Determines if the instance is within the last month
     *
     * @return bool
     */
    public function isLastMonth(): bool
    {
        return $this->month() === static::now($this->timezone())->modify('-1 month')->month();
    }

    /**
     * Determines if the instance is within the last week
     *
     * @return bool
     */
    public function isLastWeek(): bool
    {
        return $this->weekOfYear() === static::now($this->timezone())->modify('-1 week')->weekOfYear();
    }

    /**
     * Determines if the instance is within next year
     *
     * @return bool
     */
    public function isNextYear(): bool
    {
        return $this->year() === static::now($this->timezone())->modify('+1 year')->year();
    }

    /**
     * Determines if the instance is within the previous year
     *
     * @return bool
     */
    public function isLastYear(): bool
    {
        return $this->year() === static::now($this->timezone())->modify('-1 year')->year();
    }

    /**
     * Determines if the instance is in the future, ie. greater (after) than now
     *
     * @return bool
     */
    public function isFuture(): bool
    {
        return $this->gt(static::now($this->timezone()));
    }

    /**
     * Determines if the instance is in the past, ie. less (before) than now
     *
     * @return bool
     */
    public function isPast(): bool
    {
        return $this->lt(static::now($this->timezone()));
    }

    /**
     * Determines if the instance is a leap year
     *
     * @return bool
     */
    public function isLeapYear(): bool
    {
        return $this->format('L') === '1';
    }

    /**
     * Determines if the instance is a long year
     *
     * @see https://en.wikipedia.org/wiki/ISO_8601#Week_dates
     *
     * @return bool
     */
    public function isLongYear(): bool
    {
        return static::create($this->year(), 12, 28, 0, 0, 0, $this->timezone())->weekOfYear() === 53;
    }

    /**
     * Compares the formatted values of the two dates.
     *
     * @param string        $format The date formats to compare.
     * @param DateTime|null $dt     The instance to compare with or null to use current day.
     *
     * @return bool
     */
    public function isSameAs($format, DateTime $dt = null): bool
    {
        $dt = $dt ?: static::now($this->timezone());

        return $this->format($format) === $dt->format($format);
    }

    /**
     * Determines if the instance is in the current year
     *
     * @return bool
     */
    public function isCurrentYear(): bool
    {
        return $this->isSameYear();
    }

    /**
     * Checks if the passed in date is in the same year as the instance year.
     *
     * @param DateTime|null $dt The instance to compare with or null to use current day.
     *
     * @return bool
     */
    public function isSameYear(DateTime $dt = null): bool
    {
        return $this->isSameAs('Y', $dt);
    }

    /**
     * Determines if the instance is in the current month
     *
     * @return bool
     */
    public function isCurrentMonth(): bool
    {
        return $this->isSameMonth();
    }

    /**
     * Checks if the passed in date is in the same month as the instance month (and year if needed).
     *
     * @param DateTime|null $dt         The instance to compare with or null to use current day.
     * @param bool          $ofSameYear Check if it is the same month in the same year.
     *
     * @return bool
     */
    public function isSameMonth(DateTime $dt = null, $ofSameYear = false): bool
    {
        $format = $ofSameYear ? 'Y-m' : 'm';

        return $this->isSameAs($format, $dt);
    }

    /**
     * Checks if the passed in date is the same day as the instance current day.
     *
     * @param DateTime $dt
     *
     * @return bool
     */
    public function isSameDay(DateTime $dt): bool
    {
        return $this->toDateString() === $dt->toDateString();
    }
}
