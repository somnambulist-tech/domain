<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Types\DateTime;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Exception\InvalidFormat;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Somnambulist\Components\Models\Types\DateTime\DateTime;

/**
 * Type that maps an SQL DATE to a Carbon object.
 *
 * Based on: Doctrine\DBAL\Types\DateType
 */
class DateType extends Type
{
    public function getName(): string
    {
        return Types::DATE_MUTABLE;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getDateTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return ($value !== null) ? $value->format($platform->getDateFormatString()) : null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if ($value === null || $value instanceof DateTime) {
            return $value;
        }

        $val = DateTime::createFromFormat('!' . $platform->getDateFormatString(), $value);
        if (!$val) {
            throw InvalidFormat::new($value, $this->getName(), $platform->getDateFormatString());
        }

        return $val;
    }
}
