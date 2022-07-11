<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Enumerations\Serializers;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use InvalidArgumentException;
use Somnambulist\Components\Models\Types\Money\Currency;

class CurrencySerializer
{
    /**
     * @param object           $value
     * @param AbstractPlatform $platform
     *
     * @return string
     * @throws InvalidArgumentException
     */
    public function __invoke(object $value, AbstractPlatform $platform): string
    {
        if (!$value instanceof Currency) {
            throw new InvalidArgumentException(sprintf(
                '"%s" can only be used with "%s"', __CLASS__, Currency::class
            ));
        }

        return $value->code();
    }
}
