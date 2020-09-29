<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Doctrine\Types\Web;

use Assert\Assert;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;
use Somnambulist\Components\Domain\Entities\Types\Web\IPV4Address;

/**
 * Class IPV4AddressType
 *
 * @package    Somnambulist\Components\Domain\Doctrine\Types\Web
 * @subpackage Somnambulist\Components\Domain\Doctrine\Types\Web\IPV4AddressType
 */
class IPV4AddressType extends Type
{

    public const NAME = 'ip_v4_address';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof IPV4Address) {
            return $value;
        }

        try {
            $ipv4 = new IPV4Address($value);
        } catch (InvalidArgumentException $e) {
            throw ConversionException::conversionFailed($value, static::NAME);
        }

        return $ipv4;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }

        try {
            if ($value instanceof IPV4Address || Assert::that($value)->ipv4()) {
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
