<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Types\DateTime;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Somnambulist\Components\Models\Types\DateTime\DateTime;

/**
 * DateTime type saving additional timezone information, uses DateTime instances internally.
 *
 * See notes on original Doctrine type about using this with DBs.
 *
 * Based on: Doctrine\DBAL\Types\DateTimeTzType
 *
 * @link   www.doctrine-project.org
 * @since  1.0
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author Jonathan Wage <jonwage@gmail.com>
 * @author Roman Borschel <roman@code-factory.org>
 */
class DateTimeTzType extends Type
{
    public function getName(): string
    {
        return Types::DATETIMETZ_MUTABLE;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getDateTimeTzTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return ($value !== null) ? $value->format($platform->getDateTimeTzFormatString()) : null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if ($value === null || $value instanceof DateTime) {
            return $value;
        }

        $val = DateTime::createFromFormat($platform->getDateTimeTzFormatString(), $value);
        if (!$val) {
            throw ConversionException::conversionFailedFormat($value, $this->getName(), $platform->getDateTimeTzFormatString());
        }

        return $val;
    }
}
