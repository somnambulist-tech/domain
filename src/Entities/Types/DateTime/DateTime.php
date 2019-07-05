<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types\DateTime;

use DateTimeImmutable;
use Somnambulist\Domain\Entities\Contracts\ValueObjectInterface;
use Somnambulist\Domain\Entities\Types\DateTime\Traits\Comparable;
use Somnambulist\Domain\Entities\Types\DateTime\Traits\Factory;
use Somnambulist\Domain\Entities\Types\DateTime\Traits\Modifiers;
use Somnambulist\Domain\Entities\Types\DateTime\Traits\Stringable;

/**
 * Class DateTime
 *
 * @package    Somnambulist\Domain\Entities\Types\DateTime
 * @subpackage Somnambulist\Domain\Entities\Types\DateTime\DateTime
 */
class DateTime extends DateTimeImmutable implements ValueObjectInterface
{

    use Comparable;
    use Factory;
    use Modifiers;
    use Stringable;

    /**
     * @param string $name
     * @param mixed  $value
     */
    public function __set($name, $value)
    {
        // prevent arbitrary properties
    }

    /**
     * @return DateTime
     */
    public function clone(): DateTime
    {
        return clone $this;
    }

    /**
     * @return TimeZone
     */
    public function timezone(): TimeZone
    {
        return new TimeZone($this->getTimezone()->getName());
    }

    /**
     * @return int
     */
    public function year(): int
    {
        return (int)$this->format('Y');
    }

    /**
     * @return int
     */
    public function month(): int
    {
        return (int)$this->format('m');
    }

    /**
     * @return int
     */
    public function day(): int
    {
        return (int)$this->format('d');
    }

    /**
     * @return int
     */
    public function hour(): int
    {
        return (int)$this->format('H');
    }

    /**
     * @return int
     */
    public function minute(): int
    {
        return (int)$this->format('i');
    }

    /**
     * @return int
     */
    public function second(): int
    {
        return (int)$this->format('s');
    }

    /**
     * @return int
     */
    public function timestamp(): int
    {
        return (int)$this->format('U');
    }

    /**
     * @return int
     */
    public function weekOfYear(): int
    {
        return (int)$this->format('W');
    }

    /**
     * @return int
     */
    public function daysInMonth(): int
    {
        return (int)$this->format('t');
    }

    /**
     * @return int
     */
    public function dayOfWeek(): int
    {
        return (int)$this->format('w');
    }

    /**
     * @return int
     */
    public function dayOfYear(): int
    {
        return (int)$this->format('z');
    }
}
