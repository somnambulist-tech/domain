<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Doctrine\Enumerations\Constructors;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use InvalidArgumentException;
use Somnambulist\Components\Domain\Entities\Types\Geography\Country;

/**
 * Class CountryConstructor
 *
 * @package    Somnambulist\Components\Domain\Doctrine\Enumerations\Constructors
 * @subpackage Somnambulist\Components\Domain\Doctrine\Enumerations\Constructors\CountryConstructor
 */
class CountryConstructor
{
    /**
     * @param string           $value
     * @param AbstractPlatform $platform
     *
     * @return Country|null
     * @throws InvalidArgumentException
     */
    public function __invoke($value, $platform): ?Country
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
