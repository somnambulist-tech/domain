<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Types\Web;

use Assert\Assert;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Exception\ValueNotConvertible;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;
use Somnambulist\Components\Models\Types\Web\IPV4Address;

/**
 * Store IPV4 addresses as a type instead of as an embeddable.
 */
class IPV4AddressType extends Type
{
    public const NAME = 'ip_v4_address';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof IPV4Address) {
            return $value;
        }

        try {
            $ipv4 = new IPV4Address($value);
        } catch (InvalidArgumentException) {
            throw ValueNotConvertible::new($value, static::NAME);
        }

        return $ipv4;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (empty($value)) {
            return null;
        }

        try {
            if ($value instanceof IPV4Address || Assert::that($value)->ipv4()) {
                return (string)$value;
            }
        } catch (InvalidArgumentException) {

        }

        throw ValueNotConvertible::new($value, static::NAME);
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
