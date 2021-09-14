<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities\Types\DateTime;

use Assert\Assert;
use DateTimeZone;
use Somnambulist\Components\Domain\Entities\AbstractValueObject;

/**
 * Class TimeZone
 *
 * @package    Somnambulist\Components\Domain\Entities\Types\DateTime
 * @subpackage Somnambulist\Components\Domain\Entities\Types\DateTime\TimeZone
 */
class TimeZone extends AbstractValueObject
{
    private string $value;

    public function __construct(string $tz)
    {
        Assert::that($tz, null, 'value')
            ->notEmpty()
            ->satisfy(static fn ($value) => false !== @timezone_open($value))
        ;

        $this->value = $tz;
    }

    public static function create(string $tz = null): static
    {
        return new static($tz ?? date_default_timezone_get());
    }

    public static function utc(): static
    {
        return new static('UTC');
    }

    public function toString(): string
    {
        return (string)$this->value;
    }

    public function toNative(): DateTimeZone
    {
        return new DateTimeZone($this->value);
    }
}
