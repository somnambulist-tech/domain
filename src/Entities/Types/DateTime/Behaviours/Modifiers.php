<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities\Types\DateTime\Behaviours;

/**
 * Trait Modifiers
 *
 * @package    Somnambulist\Components\Domain\Entities\Types\DateTime\Behaviours
 * @subpackage Somnambulist\Components\Domain\Entities\Types\DateTime\Behaviours\Modifiers
 */
trait Modifiers
{
    public function addDays(int $num): static
    {
        return $this->modify(sprintf('%d day', $num));
    }

    public function subDays(int $num): static
    {
        return $this->addDays(-1 * $num);
    }

    public function addWeeks(int $num): static
    {
        return $this->modify(sprintf('%d week', $num));
    }

    public function subWeeks(int $num): static
    {
        return $this->addWeeks(-1 * $num);
    }

    public function addMonths(int $num): static
    {
        return $this->modify(sprintf('%d month', $num));
    }

    public function subMonths(int $num): static
    {
        return $this->addMonths(-1 * $num);
    }

    public function addYears(int $num): static
    {
        return $this->modify(sprintf('%d year', $num));
    }

    public function subYears(int $num): static
    {
        return $this->addYears(-1 * $num);
    }

    public function addSeconds(int $num): static
    {
        return $this->modify(sprintf('%d second', $num));
    }

    public function subSeconds(int $num): static
    {
        return $this->addSeconds(-1 * $num);
    }

    public function addMinutes(int $num): static
    {
        return $this->modify(sprintf('%d minute', $num));
    }

    public function subMinutes(int $num): static
    {
        return $this->addMinutes(-1 * $num);
    }

    public function addHours(int $num): static
    {
        return $this->modify(sprintf('%d hour', $num));
    }

    public function subHours(int $num): static
    {
        return $this->addHours(-1 * $num);
    }
}
