<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types\DateTime;

use DateTimeImmutable;
use DateTimeZone;
use Somnambulist\Components\Models\Contracts\ValueObject;
use Somnambulist\Components\Models\Types\DateTime\Behaviours\Comparable;
use Somnambulist\Components\Models\Types\DateTime\Behaviours\Factory;
use Somnambulist\Components\Models\Types\DateTime\Behaviours\Modifiers;
use Somnambulist\Components\Models\Types\DateTime\Behaviours\Shifters;
use Somnambulist\Components\Models\Types\DateTime\Behaviours\Stringable;

class DateTime extends DateTimeImmutable implements ValueObject
{
    use Comparable;
    use Factory;
    use Modifiers;
    use Shifters;
    use Stringable;

    public function __set($name, $value)
    {
        // prevent arbitrary properties
    }

    public function format(string|DateFormat $format): string
    {
        return parent::format((string)$format);
    }

    public function clone(): static
    {
        return clone $this;
    }

    public function toUtc(): static
    {
        return $this->setTimezone(new DateTimeZone('UTC'));
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

    public function millisecond(): int
    {
        return (int)$this->format('v');
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

    public function firstDayOfWeek(): int
    {
        // 0=Sun 1=Mon 2=Tue 3=Wed 4=Thu 5=Fri 6=Sat
        return (new self('this week'))->dayOfWeek();
    }

    public function lastDayOfWeek(int $firstDow = -1): int
    {
        ($firstDow >= 0) or ($firstDow = $this->firstDayOfWeek());

        return ($firstDow + 6) % 7;
    }

    public function dayOfYear(): int
    {
        return (int)$this->format('z');
    }
}
