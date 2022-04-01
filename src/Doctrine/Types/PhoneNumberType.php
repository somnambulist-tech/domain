<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Doctrine\Types;

use Assert\Assert;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;
use Somnambulist\Components\Domain\Entities\Types\PhoneNumber;

/**
 * Class UrlType
 *
 * Store email address ValueObjects as strings and re-hydrate, without needing to use an
 * embeddable.
 *
 * @package    Somnambulist\Components\Domain\Doctrine\Types
 * @subpackage Somnambulist\Components\Domain\Doctrine\Types\PhoneNumberType
 */
class PhoneNumberType extends Type
{
    const NAME = 'phone_number';

    /**
     * {@inheritdoc}
     *
     * @param array            $column
     * @param AbstractPlatform $platform
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getVarcharTypeDeclarationSQL($column);
    }

    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     *
     * @return mixed|PhoneNumber|null
     * @throws ConversionException
     */
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

    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     *
     * @return mixed|string|null
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
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

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getName(): string
    {
        return static::NAME;
    }

    /**
     * {@inheritdoc}
     *
     * @param AbstractPlatform $platform
     *
     * @return boolean
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
