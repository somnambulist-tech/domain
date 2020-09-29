<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities\Types\DateTime\Behaviours;

use DateTime;

/**
 * Trait Stringable
 *
 * Based on Carbon\Carbon test setup methods.
 *
 * @package    Somnambulist\Components\Domain\Entities\Types\DateTime\Behaviours
 * @subpackage Somnambulist\Components\Domain\Entities\Types\DateTime\Behaviours\Stringable
 */
trait Stringable
{

    private string $defaultFormat = 'Y-m-d H:i:s';

    public function __toString()
    {
        return $this->toString();
    }

    public function toString(): string
    {
        return $this->format($this->defaultFormat);
    }

    public function setDefaultFormat(string $format): self
    {
        $this->defaultFormat = $format;

        return $this;
    }

    abstract public function format($format);

    public function toDateString(): string
    {
        return $this->format('Y-m-d');
    }

    public function toFormattedDateString(): string
    {
        return $this->format('M j, Y');
    }

    public function toTimeString(): string
    {
        return $this->format('H:i:s');
    }

    public function toDateTimeString(): string
    {
        return $this->format('Y-m-d H:i:s');
    }

    public function toDayDateTimeString(): string
    {
        return $this->format('D, M j, Y g:i A');
    }

    public function toAtomString(): string
    {
        return $this->format(DateTime::ATOM);
    }

    public function toCookieString(): string
    {
        return $this->format(DateTime::COOKIE);
    }

    public function toIso8601String(): string
    {
        return $this->toAtomString();
    }

    public function toRfc822String(): string
    {
        return $this->format(DateTime::RFC822);
    }

    public function toRfc2822String(): string
    {
        return $this->format(DateTime::RFC2822);
    }

    public function toRssString(): string
    {
        return $this->format(DateTime::RSS);
    }

    public function toW3cString(): string
    {
        return $this->format(DateTime::W3C);
    }
}
