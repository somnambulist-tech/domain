<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Types\DateTime;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Exception\InvalidFormat;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Somnambulist\Components\Models\Types\DateTime\DateTime;

/**
 * Type that maps an SQL DATETIME/TIMESTAMP to a PHP DateTime object.
 *
 * Based on: Doctrine\DBAL\Types\DateTimeType
 *
 * @since 2.0
 */
class DateTimeType extends Type
{
    public function getName(): string
    {
        return Types::DATETIME_MUTABLE;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getDateTimeTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return ($value !== null) ? $value->format($platform->getDateTimeFormatString()) : null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if ($value === null || $value instanceof DateTime) {
            return $value;
        }

        $val = DateTime::createFromFormat($platform->getDateTimeFormatString(), $value);

        if (!$val) {
            $val = new DateTime($value);
        }

        if (!$val) {
            throw InvalidFormat::new($value, $this->getName(), $platform->getDateTimeFormatString());
        }

        return $val;
    }
}
