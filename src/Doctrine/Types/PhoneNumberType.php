<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Types;

use Assert\Assert;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;
use Somnambulist\Components\Models\Types\PhoneNumber;

/**
 * Store phone number ValueObjects as strings and re-hydrate, without needing to use an
 * embeddable.
 */
class PhoneNumberType extends Type
{
    const NAME = 'phone_number';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof PhoneNumber) {
            return $value;
        }

        try {
            $uuid = new PhoneNumber($value);
        } catch (InvalidArgumentException) {
            throw ConversionException::conversionFailed($value, static::NAME);
        }

        return $uuid;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (empty($value)) {
            return null;
        }

        try {
            if ($value instanceof PhoneNumber || Assert::that($value)->e164()) {
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
