<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities\Types\Money;

use Somnambulist\Components\Domain\Entities\AbstractValueObject;

/**
 * Class Money
 *
 * @package    Somnambulist\Components\Domain\Entities\Types\Money
 * @subpackage Somnambulist\Components\Domain\Entities\Types\Money\Money
 */
final class Money extends AbstractValueObject
{

    private float $amount;
    private Currency $currency;

    public function __construct(float $amount, Currency $currency)
    {
        $this->amount   = $amount;
        $this->currency = $currency;
    }

    public static function create(float $amount, $code): self
    {
        return new static($amount, ($code instanceof Currency ? $code : Currency::memberByKey($code)));
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
