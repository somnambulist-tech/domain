<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types\DateTime\Traits;

use DateTime;

/**
 * Trait Stringable
 *
 * Based on Carbon\Carbon test setup methods.
 *
 * @package    Somnambulist\Domain\Entities\Types\DateTime\Traits
 * @subpackage Somnambulist\Domain\Entities\Types\DateTime\Traits\Stringable
 */
trait Stringable
{

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->format('Y-m-d H:i:s');
    }

    /**
     * @param string $format
     *
     * @return string
     */
    abstract public function format($format);

    /**
     * Format the instance as date
     *
     * @return string
     */
    public function toDateString(): string
    {
        return $this->format('Y-m-d');
    }

    /**
     * Format the instance as a readable date
     *
     * @return string
     */
    public function toFormattedDateString(): string
    {
        return $this->format('M j, Y');
    }

    /**
     * Format the instance as time
     *
     * @return string
     */
    public function toTimeString(): string
    {
        return $this->format('H:i:s');
    }

    /**
     * Format the instance as date and time
     *
     * @return string
     */
    public function toDateTimeString(): string
    {
        return $this->format('Y-m-d H:i:s');
    }

    /**
     * Format the instance with day, date and time
     *
     * @return string
     */
    public function toDayDateTimeString(): string
    {
        return $this->format('D, M j, Y g:i A');
    }

    /**
     * Format the instance as ATOM
     *
     * @return string
     */
    public function toAtomString(): string
    {
        return $this->format(DateTime::ATOM);
    }

    /**
     * Format the instance as COOKIE
     *
     * @return string
     */
    public function toCookieString(): string
    {
        return $this->format(DateTime::COOKIE);
    }

    /**
     * Format the instance as ISO8601
     *
     * @return string
     */
    public function toIso8601String(): string
    {
        return $this->toAtomString();
    }

    /**
     * Format the instance as RFC822
     *
     * @return string
     */
    public function toRfc822String(): string
    {
        return $this->format(DateTime::RFC822);
    }

    /**
     * Format the instance as RFC2822
     *
     * @return string
     */
    public function toRfc2822String(): string
    {
        return $this->format(DateTime::RFC2822);
    }

    /**
     * Format the instance as RSS
     *
     * @return string
     */
    public function toRssString(): string
    {
        return $this->format(DateTime::RSS);
    }

    /**
     * Format the instance as W3C
     *
     * @return string
     */
    public function toW3cString(): string
    {
        return $this->format(DateTime::W3C);
    }
}
