<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types\DateTime;

use DateTimeImmutable;
use Somnambulist\Domain\Entities\Contracts\ValueObject;
use Somnambulist\Domain\Entities\Types\DateTime\Behaviours\Comparable;
use Somnambulist\Domain\Entities\Types\DateTime\Behaviours\Factory;
use Somnambulist\Domain\Entities\Types\DateTime\Behaviours\Modifiers;
use Somnambulist\Domain\Entities\Types\DateTime\Behaviours\Stringable;

/**
 * Class DateTime
 *
 * @package    Somnambulist\Domain\Entities\Types\DateTime
 * @subpackage Somnambulist\Domain\Entities\Types\DateTime\DateTime
 */
class DateTime extends DateTimeImmutable implements ValueObject
{

    use Comparable;
    use Factory;
    use Modifiers;
    use Stringable;

    public function __set($name, $value)
    {
        // prevent arbitrary properties
    }

    public function clone(): DateTime
    {
        return clone $this;
    }

    public function timezone(): TimeZone
    {
        return new TimeZone($this->getTimezone()->getName());
    }

    public function year(): int
    {
        return (int)$this->format('Y');
    }

    public function month(): int
    {
        return (int)$this->format('m');
    }

    public function day(): int
    {
        return (int)$this->format('d');
    }

    public function hour(): int
    {
        return (int)$this->format('H');
    }

    public function minute(): int
    {
        return (int)$this->format('i');
    }

    public function second(): int
    {
        return (int)$this->format('s');
    }

    public function timestamp(): int
    {
        return (int)$this->format('U');
    }

    public function weekOfYear(): int
    {
        return (int)$this->format('W');
    }

    public function daysInMonth(): int
    {
        return (int)$this->format('t');
    }

    public function dayOfWeek(): int
    {
        return (int)$this->format('w');
    }

    public function dayOfYear(): int
    {
        return (int)$this->format('z');
    }
}
