<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Doctrine\Enumerations\Serializers;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use InvalidArgumentException;
use Somnambulist\Components\Domain\Entities\Types\Money\Currency;

/**
 * Class CurrencySerializer
 *
 * @package    Somnambulist\Components\Domain\Doctrine\Enumerations\Serializers
 * @subpackage Somnambulist\Components\Domain\Doctrine\Enumerations\Serializers\CurrencySerializer
 */
class CurrencySerializer
{
    /**
     * @param object           $value
     * @param AbstractPlatform $platform
     *
     * @return string
     * @throws InvalidArgumentException
     */
    public function __invoke($value, AbstractPlatform $platform): string
    {
        if (!$value instanceof Currency) {
            throw new InvalidArgumentException(sprintf(
                '"%s" can only be used with "%s"', __CLASS__, Currency::class
            ));
        }

        return $value->code();
    }
}
