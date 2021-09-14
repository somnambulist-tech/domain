<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities\Types\DateTime\Behaviours;

/**
 * Trait Shifters
 *
 * @package    Somnambulist\Components\Domain\Entities\Types\DateTime\Behaviours
 * @subpackage Somnambulist\Components\Domain\Entities\Types\DateTime\Behaviours\Shifters
 */
trait Shifters
{
    public function startOf(string $unit, ...$args): static
    {
        $method = 'startOf' . ucfirst(strtolower($unit));

        return $this->{$method}(...$args);
    }

    public function endOf(string $unit, ...$args): static
    {
        $method = 'endOf' . ucfirst(strtolower($unit));

        return $this->{$method}(...$args);
    }

    public function startOfMinute(): static
    {
        return $this->setTime($this->hour(), $this->minute());
    }

    public function endOfMinute(): static
    {
        return $this->setTime($this->hour(), $this->minute(), 59);
    }

    public function startOfHour(): static
    {
        return $this->setTime($this->hour(), 0);
    }

    public function endOfHour(): static
    {
        return $this->setTime($this->hour(), 59, 59);
    }

    public function startOfDay(): static
    {
        return $this->setTime(0, 0);
    }

    public function endOfDay(): static
    {
        return $this->setTime(23, 59, 59);
    }

    public function startOfWeek(int $firstDow = -1): static
    {
        ($firstDow >= 0) or ($firstDow = $this->firstDayOfWeek());

        return $this->subDays(($this->dayOfWeek() + 7 - $firstDow) % 7)->startOfDay();
    }

    public function endOfWeek(int $firstDow = -1): static
    {
        return $this->addDays(($this->lastDayOfWeek($firstDow) + 7 - $this->dayOfWeek()) % 7)->endOfDay();
    }

    public function startOfMonth(): static
    {
        return $this->setDate($this->year(), $this->month(), 1)->startOfDay();
    }

    public function endOfMonth(): static
    {
        return $this->setDate($this->year(), $this->month(), $this->daysInMonth())->endOfDay();
    }

    public function startOfQuarter(): static
    {
        $month = (int)(floor(($this->month() - 1) / 3) * 3) + 1;

        return $this->setDate($this->year(), $month, 1)->startOfDay();
    }

    public function endOfQuarter(): static
    {
        $month = (int)(floor(($this->month() - 1) / 3) * 3) + 3;

        return $this->setDate($this->year(), $month, 1)->endOfMonth();
    }

    public function startOfYear(): static
    {
        return $this->setDate($this->year(), 1, 1)->startOfDay();
    }

    public function endOfYear(): static
    {
        return $this->setDate($this->year(), 12, 31)->endOfDay();
    }
}
