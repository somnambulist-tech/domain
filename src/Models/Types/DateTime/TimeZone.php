<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types\DateTime;

use Assert\Assert;
use DateTimeZone;
use Somnambulist\Components\Models\AbstractValueObject;

final readonly class TimeZone extends AbstractValueObject
{
    public function __construct(private string $value)
    {
        Assert::that($value, null, 'timezone')
            ->notEmpty()
            ->satisfy(static fn ($value) => false !== @timezone_open($value))
        ;
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
        return $this->value;
    }

    public function toNative(): DateTimeZone
    {
        return new DateTimeZone($this->value);
    }
}
