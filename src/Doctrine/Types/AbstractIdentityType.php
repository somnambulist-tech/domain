<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Types;

use Assert\Assert;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Exception\ValueNotConvertible;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;
use Somnambulist\Components\Doctrine\TypeBootstrapper;
use Somnambulist\Components\Models\Types\Identity\Uuid;

/**
 * Provides a type base that can be extended to set a specific identity class instead
 * of being hard-wired for only "uuid" etc. Extend and override the name and class
 * with the values you need, then register the type either directly in the Doctrine
 * config or via the {@see TypeBootstrapper}
 */
abstract class AbstractIdentityType extends Type
{
    protected string $name = 'identity';
    protected string $class = Uuid::class;

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($column);
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
            throw ValueNotConvertible::new($value, $this->name);
        }

        return $uuid;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (empty($value)) {
            return null;
        }

        try {
            if ($value instanceof $this->class || Assert::that($value)->uuid()) {
                return (string)$value;
            }
        } catch (InvalidArgumentException) {

        }

        throw ValueNotConvertible::new($value, $this->name);
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
