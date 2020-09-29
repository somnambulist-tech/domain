<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Doctrine\Enumerations\Serializers;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use InvalidArgumentException;
use Somnambulist\Components\Domain\Entities\Types\Geography\Country;

/**
 * Class CountrySerializer
 *
 * @package    Somnambulist\Components\Domain\Doctrine\Enumerations\Serializers
 * @subpackage Somnambulist\Components\Domain\Doctrine\Enumerations\Serializers\CountrySerializer
 */
class CountrySerializer
{

    /**
     * @param object           $value
     * @param AbstractPlatform $platform
     *
     * @return string
     * @throws InvalidArgumentException
     */
    public function __invoke($value, AbstractPlatform $platform)
    {
        if (!$value instanceof Country) {
            throw new InvalidArgumentException(sprintf(
                '"%s" can only be used with "%s"', __CLASS__, Country::class
            ));
        }

        return (string)$value->code();
    }
}
