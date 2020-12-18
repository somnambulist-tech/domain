<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities\Types\DateTime\Behaviours;

use Somnambulist\Components\Domain\Entities\Types\DateTime\DateTime;

/**
 * Trait Modifiers
 *
 * @package    Somnambulist\Components\Domain\Entities\Types\DateTime\Behaviours
 * @subpackage Somnambulist\Components\Domain\Entities\Types\DateTime\Behaviours\Modifiers
 */
trait Modifiers
{

    public function addDays(int $num): DateTime
    {
        return $this->modify(sprintf('%d day', $num));
    }

    public function subDays(int $num): DateTime
    {
        return $this->addDays(-1 * $num);
    }

    public function addWeeks(int $num): DateTime
    {
        return $this->modify(sprintf('%d week', $num));
    }

    public function subWeeks(int $num): DateTime
    {
        return $this->addWeeks(-1 * $num);
    }

    public function addMonths(int $num): DateTime
    {
        return $this->modify(sprintf('%d month', $num));
    }

    public function subMonths(int $num): DateTime
    {
        return $this->addMonths(-1 * $num);
    }

    public function addYears(int $num): DateTime
    {
        return $this->modify(sprintf('%d year', $num));
    }

    public function subYears(int $num): DateTime
    {
        return $this->addYears(-1 * $num);
    }

    public function addSeconds(int $num): DateTime
    {
        return $this->modify(sprintf('%d second', $num));
    }

    public function subSeconds(int $num): DateTime
    {
        return $this->addSeconds(-1 * $num);
    }

    public function addMinutes(int $num): DateTime
    {
        return $this->modify(sprintf('%d minute', $num));
    }

    public function subMinutes(int $num): DateTime
    {
        return $this->addMinutes(-1 * $num);
    }

    public function addHours(int $num): DateTime
    {
        return $this->modify(sprintf('%d hour', $num));
    }

    public function subHours(int $num): DateTime
    {
        return $this->addHours(-1 * $num);
    }
}
