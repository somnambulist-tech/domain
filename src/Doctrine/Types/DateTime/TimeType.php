<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Doctrine\Types\DateTime;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Somnambulist\Components\Domain\Entities\Types\DateTime\DateTime;

/**
 * Type that maps an SQL TIME to a DateTime object.
 *
 * Based on: Doctrine\DBAL\Types\TimeType
 */
class TimeType extends Type
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return Types::TIME_MUTABLE;
    }

    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getTimeTypeDeclarationSQL($column);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return ($value !== null) ? $value->format($platform->getTimeFormatString()) : null;
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if ($value === null || $value instanceof DateTime) {
            return $value;
        }

        $val = DateTime::createFromFormat('!' . $platform->getTimeFormatString(), $value);
        if (!$val) {
            throw ConversionException::conversionFailedFormat($value, $this->getName(), $platform->getTimeFormatString());
        }

        return $val;
    }
}
