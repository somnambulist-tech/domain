<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Doctrine\Types;

use Assert\Assert;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;
use Somnambulist\Components\Domain\Doctrine\TypeBootstrapper;
use Somnambulist\Components\Domain\Entities\Types\Identity\Uuid;

/**
 * Class AbstractIdentityType
 *
 * Provides a type base that can be extended to set a specific identity class instead
 * of being hard-wired for only "uuid" etc. Extend and override the name and class
 * with the values you need, then register the type either directly in the Doctrine
 * config or via the {@see TypeBootstrapper}
 *
 * @package    Somnambulist\Components\Domain\Doctrine\Types
 * @subpackage Somnambulist\Components\Domain\Doctrine\Types\AbstractIdentityType
 */
abstract class AbstractIdentityType extends Type
{

    protected string $name = 'identity';
    protected string $class = Uuid::class;

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getGuidTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof $this->class) {
            return $value;
        }

        try {
            $uuid = new $this->class($value);
        } catch (InvalidArgumentException $e) {
            throw ConversionException::conversionFailed($value, $this->name);
        }

        return $uuid;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }

        try {
            if ($value instanceof $this->class || Assert::that($value)->uuid()) {
                return (string)$value;
            }
        } catch (InvalidArgumentException $e) {

        }

        throw ConversionException::conversionFailed($value, $this->name);
    }

    public function getName()
    {
        return $this->name;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
