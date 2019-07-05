<?php declare(strict_types=1);

namespace Somnambulist\Domain\Doctrine\Enumerations\Constructors;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use InvalidArgumentException;
use Somnambulist\Domain\Entities\Types\Geography\Country;

/**
 * Class CountryEnumeration
 *
 * Builds a Country value-object from a country code enumeration.
 *
 * @package    Somnambulist\Domain\Doctrine\Enumerations\Constructors
 * @subpackage Somnambulist\Domain\Doctrine\Enumerations\Constructors\CountryEnumeration
 */
class CountryEnumeration
{

    /**
     * @param string           $value
     * @param string           $class
     * @param AbstractPlatform $platform
     *
     * @return Country
     * @throws InvalidArgumentException
     */
    public function __invoke($value, $class, $platform)
    {
        if (is_null($value)) {
            return null;
        }

        if (null !== $country = Country::memberOrNullByKey($value)) {
            return $country;
        }

        throw new InvalidArgumentException(sprintf('"%s" is not a valid value for "%s"', $value, Country::class));
    }
}
