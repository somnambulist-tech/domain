<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;
use Somnambulist\Components\Models\AbstractValueObject;

/**
 * For simple (single value) Value Objects, allows a custom type to be mapped to Doctrine.
 * This allows the definition to be <field name="" type="name_here" /> instead of needing
 * to use an embedded field.
 */
abstract class AbstractValueObjectType extends Type
{
    protected string $name = 'value_object';
    protected string $class = AbstractValueObject::class;

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getVarcharTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof $this->class) {
            return $value;
        }

        try {
            $uuid = new $this->class($value);
        } catch (InvalidArgumentException) {
            throw ConversionException::conversionFailed($value, $this->name);
        }

        return $uuid;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if (empty($value)) {
            return null;
        }

        try {
            if ($value instanceof $this->class) {
                return (string)$value;
            }
        } catch (InvalidArgumentException) {

        }

        throw ConversionException::conversionFailed($value, $this->name);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
