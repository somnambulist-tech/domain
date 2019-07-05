<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types\DateTime\Traits;

use Somnambulist\Domain\Entities\Types\DateTime\DateTime;

/**
 * Trait Modifiers
 *
 * @package    Somnambulist\Domain\Entities\Types\DateTime\Traits
 * @subpackage Somnambulist\Domain\Entities\Types\DateTime\Traits\Modifiers
 */
trait Modifiers
{

    /**
     * @param integer $num
     *
     * @return DateTime
     */
    public function addDays($num): self
    {
        return $this->modify(sprintf('%d day', $num));
    }

    /**
     * @param integer $num
     *
     * @return DateTime
     */
    public function subDays($num): self
    {
        return $this->addDays(-1 * $num);
    }

    /**
     * @param integer $num
     *
     * @return DateTime
     */
    public function addWeeks($num): self
    {
        return $this->modify(sprintf('%d week', $num));
    }

    /**
     * @param integer $num
     *
     * @return DateTime
     */
    public function subWeeks($num): self
    {
        return $this->addWeeks(-1 * $num);
    }

    /**
     * @param integer $num
     *
     * @return DateTime
     */
    public function addMonths($num): self
    {
        return $this->modify(sprintf('%d month', $num));
    }

    /**
     * @param integer $num
     *
     * @return DateTime
     */
    public function subMonths($num): self
    {
        return $this->addMonths(-1 * $num);
    }

    /**
     * @param integer $num
     *
     * @return DateTime
     */
    public function addYears($num): self
    {
        return $this->modify(sprintf('%d year', $num));
    }

    /**
     * @param integer $num
     *
     * @return DateTime
     */
    public function subYears($num): self
    {
        return $this->addYears(-1 * $num);
    }

    /**
     * @param integer $num
     *
     * @return DateTime
     */
    public function addSeconds($num): self
    {
        return $this->modify(sprintf('%d second', $num));
    }

    /**
     * @param integer $num
     *
     * @return DateTime
     */
    public function subSeconds($num): self
    {
        return $this->addSeconds(-1 * $num);
    }

    /**
     * @param integer $num
     *
     * @return DateTime
     */
    public function addMinutes($num): self
    {
        return $this->modify(sprintf('%d minute', $num));
    }

    /**
     * @param integer $num
     *
     * @return DateTime
     */
    public function subMinutes($num): self
    {
        return $this->addMinutes(-1 * $num);
    }

    /**
     * @param integer $num
     *
     * @return DateTime
     */
    public function addHours($num): self
    {
        return $this->modify(sprintf('%d hour', $num));
    }

    /**
     * @param integer $num
     *
     * @return DateTime
     */
    public function subHours($num): self
    {
        return $this->addHours(-1 * $num);
    }
}
