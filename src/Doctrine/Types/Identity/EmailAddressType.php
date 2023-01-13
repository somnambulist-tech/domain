<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Types\Identity;

use Assert\Assert;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;
use Somnambulist\Components\Models\Types\Identity\EmailAddress;

/**
 * Store email address ValueObjects as strings and re-hydrate, without needing to use an
 * embeddable.
 */
class EmailAddressType extends Type
{
    public const NAME = 'email_address';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof EmailAddress) {
            return $value;
        }

        try {
            $vo = new EmailAddress($value);
        } catch (InvalidArgumentException) {
            throw ConversionException::conversionFailed($value, static::NAME);
        }

        return $vo;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (empty($value)) {
            return null;
        }

        try {
            if ($value instanceof EmailAddress || Assert::that($value)->email()) {
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
