<?php declare(strict_types=1);

namespace Somnambulist\Domain\Doctrine\Types\Identity;

use Assert\Assert;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;
use Somnambulist\Domain\Entities\Types\Identity\EmailAddress;

/**
 * Class UrlType
 *
 * Store email address ValueObjects as strings and re-hydrate, without needing to use an
 * embeddable.
 *
 * @package    Somnambulist\Domain\Doctrine\Types
 * @subpackage Somnambulist\Domain\Doctrine\Types\Identity\EmailAddressType
 */
class EmailAddressType extends Type
{

    public const NAME = 'email_address';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof EmailAddress) {
            return $value;
        }

        try {
            $uuid = new EmailAddress($value);
        } catch (InvalidArgumentException $e) {
            throw ConversionException::conversionFailed($value, static::NAME);
        }

        return $uuid;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }

        try {
            if ($value instanceof EmailAddress || Assert::that($value)->email()) {
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

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
