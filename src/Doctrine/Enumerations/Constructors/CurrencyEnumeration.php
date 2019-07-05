<?php declare(strict_types=1);

namespace Somnambulist\Domain\Doctrine\Enumerations\Constructors;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use InvalidArgumentException;
use Somnambulist\Domain\Entities\Types\Money\Currency;

/**
 * Class CurrencyEnumeration
 *
 * Builds a Currency value object from the currency code enumeration.
 *
 * @package    Somnambulist\Domain\Doctrine\Enumerations\Constructors
 * @subpackage Somnambulist\Domain\Doctrine\Enumerations\Constructors\CurrencyEnumeration
 */
class CurrencyEnumeration
{

    /**
     * @param string           $value
     * @param string           $class
     * @param AbstractPlatform $platform
     *
     * @return Currency
     * @throws InvalidArgumentException
     */
    public function __invoke($value, $class, $platform)
    {
        if (is_null($value)) {
            return null;
        }

        if (null !== $currency = Currency::memberOrNullByKey($value)) {
            return $currency;
        }

        throw new InvalidArgumentException(sprintf('"%s" is not a valid value for "%s"', $value, Currency::class));
    }
}
