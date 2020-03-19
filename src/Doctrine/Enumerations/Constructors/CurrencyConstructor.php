<?php declare(strict_types=1);

namespace Somnambulist\Domain\Doctrine\Enumerations\Constructors;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use InvalidArgumentException;
use Somnambulist\Domain\Entities\Types\Money\Currency;

/**
 * Class CurrencyConstructor
 *
 * @package    Somnambulist\Domain\Doctrine\Enumerations\Constructors
 * @subpackage Somnambulist\Domain\Doctrine\Enumerations\Constructors\CurrencyConstructor
 */
class CurrencyConstructor
{

    /**
     * @param string           $value
     * @param AbstractPlatform $platform
     *
     * @return Currency
     * @throws InvalidArgumentException
     */
    public function __invoke($value, $platform)
    {
        if (is_null($value)) {
            return null;
        }

        if (null !== $currency = Currency::memberOrNullByKey($value)) {
            return $currency;
        }

        throw new InvalidArgumentException(sprintf('"%s" is not a valid key for "%s"', $value, Currency::class));
    }
}
