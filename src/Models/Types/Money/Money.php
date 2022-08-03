<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types\Money;

use Somnambulist\Components\Models\AbstractValueObject;

/**
 * Represents an amount of money in the domain
 *
 * Note: this value object is not intended to be used for calculating values. You
 * should use a dedicated library for handling actual calculations, and then convert
 * the result to this value object for storage.
 */
final class Money extends AbstractValueObject
{
    public function __construct(private readonly float $amount, private readonly Currency $currency)
    {
    }

    public static function create(float $amount, string|Currency $code): self
    {
        return new self($amount, ($code instanceof Currency ? $code : Currency::memberByKey($code)));
    }

    public function toString(): string
    {
        return sprintf('%s %s', $this->currency->code(), $this->rounded());
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function rounded(): string
    {
        return number_format($this->amount, $this->currency->precision());
    }

    public function currency(): Currency
    {
        return $this->currency;
    }
}
