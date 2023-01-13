<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Enumerations\Constructors;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use InvalidArgumentException;
use Somnambulist\Components\Models\Types\Money\Currency;

class CurrencyConstructor
{
    public function __invoke(?string $value, AbstractPlatform $platform): ?Currency
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
