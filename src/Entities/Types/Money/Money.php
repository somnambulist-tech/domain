<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types\Money;

use Somnambulist\Domain\Entities\AbstractValueObject;

/**
 * Class Money
 *
 * @package    Somnambulist\Domain\Entities\Types\Money
 * @subpackage Somnambulist\Domain\Entities\Types\Money\Money
 */
class Money extends AbstractValueObject
{

    /**
     * @var float
     */
    private $amount;

    /**
     * @var Currency
     */
    private $currency;

    /**
     * Constructor.
     *
     * @param float    $amount
     * @param Currency $currency
     */
    public function __construct(float $amount, Currency $currency)
    {
        $this->amount   = $amount;
        $this->currency = $currency;
    }

    /**
     * @param float  $amount
     * @param string $code
     *
     * @return static
     */
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

    /**
     * Returns the float amount to the currencies precision value
     *
     * @return string
     */
    public function rounded()
    {
        return number_format($this->amount, $this->currency->precision());
    }

    public function currency(): Currency
    {
        return $this->currency;
    }
}
