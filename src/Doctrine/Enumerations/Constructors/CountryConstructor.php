<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Enumerations\Constructors;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use InvalidArgumentException;
use Somnambulist\Components\Models\Types\Geography\Country;

class CountryConstructor
{
    public function __invoke(?string $value, AbstractPlatform $platform): ?Country
    {
        if (is_null($value)) {
            return null;
        }

        if (null !== $country = Country::memberOrNullByKey($value)) {
            return $country;
        }

        throw new InvalidArgumentException(sprintf('"%s" is not a valid key for "%s"', $value, Country::class));
    }
}
