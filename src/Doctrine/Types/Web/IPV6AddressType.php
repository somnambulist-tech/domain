<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Types\Web;

use Assert\Assert;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;
use Somnambulist\Components\Models\Types\Web\IPV6Address;

/**
 * Store IPV6 addresses as a type instead of as an embeddable.
 */
class IPV6AddressType extends Type
{
    public const NAME = 'ip_v6_address';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getVarcharTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof IPV6Address) {
            return $value;
        }

        try {
            $uuid = new IPV6Address($value);
        } catch (InvalidArgumentException) {
            throw ConversionException::conversionFailed($value, static::NAME);
        }

        return $uuid;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if (empty($value)) {
            return null;
        }

        try {
            if ($value instanceof IPV6Address || Assert::that($value)->ipv6()) {
                return (string)$value;
            }
        } catch (InvalidArgumentException) {

        }

        throw ConversionException::conversionFailed($value, static::NAME);
    }

    public function getName(): string
    {
        return static::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
