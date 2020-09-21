<?php declare(strict_types=1);

namespace Somnambulist\Domain\Doctrine\Types\Auth;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;
use Somnambulist\Domain\Entities\Types\Auth\Password;

/**
 * Class PasswordType
 *
 * @package    Somnambulist\Domain\Doctrine\Types\Auth
 * @subpackage Somnambulist\Domain\Doctrine\Types\Auth\PasswordType
 */
class PasswordType extends Type
{

    public const NAME = 'password';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof Password) {
            return $value;
        }

        try {
            $vo = new Password($value);
        } catch (InvalidArgumentException $e) {
            throw ConversionException::conversionFailed($value, static::NAME);
        }

        return $vo;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }

        try {
            if ($value instanceof Password) {
                return (string)$value;
            }
        } catch (InvalidArgumentException $e) {

        }

        throw ConversionException::conversionFailed($value, static::NAME);
    }

    public function getName()
    {
        return static::NAME;
    }
}
