<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types\DateTime\Behaviours;

use Somnambulist\Components\Models\Types\DateTime\DateTime;

/**
 * Based on Carbon\Carbon test setup methods.
 */
trait Comparable
{
    public function equals(object $object): bool
    {
        if (get_class($object) !== get_class($this)) {
            return false;
        }

        return $this == $object;
    }

    public function eq(DateTime $dt): bool
    {
        return $this->equals($dt);
    }

    public function ne(DateTime $dt): bool
    {
        return !$this->eq($dt);
    }

    public function notEqualTo(DateTime $dt): bool
    {
        return $this->ne($dt);
    }

    public function gt(DateTime $dt): bool
    {
        return $this > $dt;
    }

    public function greaterThan(DateTime $dt): bool
    {
        return $this->gt($dt);
    }

    public function gte(DateTime $dt): bool
    {
        return $this >= $dt;
    }

    public function greaterThanOrEqualTo(DateTime $dt): bool
    {
        return $this->gte($dt);
    }

    public function lt(DateTime $dt): bool
    {
        return $this < $dt;
    }

    public function lessThan(DateTime $dt): bool
    {
        return $this->lt($dt);
    }

    public function lte(DateTime $dt): bool
    {
        return $this <= $dt;
    }

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
    public function between(DateTime $dt1, DateTime $dt2, bool $equal = true): bool
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
    public function min(?DateTime $dt = null): static
    {
        $dt = $dt ?: static::now($this->timezone());

        return $this->lt($dt) ? $this : $dt;
    }

    /**
     * @param DateTime|null $dt
     *
     * @see min()
     *
     * @return static
     */
    public function minimum(?DateTime $dt = null): static
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
    public function max(?DateTime $dt = null): static
    {
        $dt = $dt ?: static::now($this->timezone());

        return $this->gt($dt) ? $this : $dt;
    }

    /**
     * @param DateTime|null $dt
     *
     * @see max()
     *
     * @return static
     */
    public function maximum(?DateTime $dt = null): static
    {
        return $this->max($dt);
    }

    public function isYesterday(): bool
    {
        return $this->toDateString() === static::parse('-1 day', $this->timezone())->toDateString();
    }

    public function isToday(): bool
    {
        return $this->toDateString() === static::now($this->timezone())->toDateString();
    }

    public function isTomorrow(): bool
    {
        return $this->toDateString() === static::parse('+1 day', $this->timezone())->toDateString();
    }

    public function isNextWeek(): bool
    {
        return $this->weekOfYear() === static::now($this->timezone())->modify('+1 week')->weekOfYear();
    }

    public function isNextMonth(): bool
    {
        return $this->month() === static::now($this->timezone())->modify('+1 month')->month();
    }

    public function isLastMonth(): bool
    {
        return $this->month() === static::now($this->timezone())->modify('-1 month')->month();
    }

    public function isLastWeek(): bool
    {
        return $this->weekOfYear() === static::now($this->timezone())->modify('-1 week')->weekOfYear();
    }

    public function isNextYear(): bool
    {
        return $this->year() === static::now($this->timezone())->modify('+1 year')->year();
    }

    public function isLastYear(): bool
    {
        return $this->year() === static::now($this->timezone())->modify('-1 year')->year();
    }

    public function isFuture(): bool
    {
        return $this->gt(static::now($this->timezone()));
    }

    public function isPast(): bool
    {
        return $this->lt(static::now($this->timezone()));
    }

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

    public function isSameAs(string $format, ?DateTime $dt = null): bool
    {
        $dt = $dt ?: static::now($this->timezone());

        return $this->format($format) === $dt->format($format);
    }

    public function isCurrentYear(): bool
    {
        return $this->isSameYear();
    }

    public function isSameYear(?DateTime $dt = null): bool
    {
        return $this->isSameAs('Y', $dt);
    }

    public function isCurrentMonth(): bool
    {
        return $this->isSameMonth();
    }

    public function isSameMonth(?DateTime $dt = null, bool $ofSameYear = false): bool
    {
        $format = $ofSameYear ? 'Y-m' : 'm';

        return $this->isSameAs($format, $dt);
    }

    public function isSameDay(DateTime $dt): bool
    {
        return $this->toDateString() === $dt->toDateString();
    }
}
