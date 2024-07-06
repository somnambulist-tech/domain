<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Types\DateTime;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Exception\InvalidFormat;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Somnambulist\Components\Models\Types\DateTime\DateTime;

/**
 * Type that maps an SQL TIME to a DateTime object.
 *
 * Based on: Doctrine\DBAL\Types\TimeType
 */
class TimeType extends Type
{
    public function getName(): string
    {
        return Types::TIME_MUTABLE;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getTimeTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return ($value !== null) ? $value->format($platform->getTimeFormatString()) : null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if ($value === null || $value instanceof DateTime) {
            return $value;
        }

        $val = DateTime::createFromFormat('!' . $platform->getTimeFormatString(), $value);
        if (!$val) {
            throw InvalidFormat::new($value, $this->getName(), $platform->getTimeFormatString());
        }

        return $val;
    }
}
