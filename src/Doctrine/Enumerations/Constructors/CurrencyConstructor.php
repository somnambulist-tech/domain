<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Doctrine\Enumerations\Constructors;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use InvalidArgumentException;
use Somnambulist\Components\Domain\Entities\Types\Money\Currency;

/**
 * Class CurrencyConstructor
 *
 * @package    Somnambulist\Components\Domain\Doctrine\Enumerations\Constructors
 * @subpackage Somnambulist\Components\Domain\Doctrine\Enumerations\Constructors\CurrencyConstructor
 */
class CurrencyConstructor
{
    /**
     * @param string           $value
     * @param AbstractPlatform $platform
     *
     * @return Currency|null
     * @throws InvalidArgumentException
     */
    public function __invoke($value, $platform): ?Currency
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
