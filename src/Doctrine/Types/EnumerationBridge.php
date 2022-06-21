<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Types;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;

/**
 * This class is based on PhpEnumType from acelaya\doctrine-enum-type:
 *
 * @link https://github.com/acelaya/doctrine-enum-type/blob/master/src/Type/PhpEnumType.php
 */
class EnumerationBridge extends Type
{
    private string $name;

    /**
     * A callable that can build the PHP type from the value
     *
     * @var callable
     */
    private $constructor;

    /**
     * An optional callable that can serializer the enumerable to a string (default casts to string)
     *
     * @var callable
     */
    private $serializer;

    /**
     * Register a set of types with the provided constructor and serializer callables
     *
     * @param array $types An Array of name => constructor or alias => [ constructor, serializer ]
     *
     * @throws InvalidArgumentException|Exception
     */
    public static function registerEnumTypes(array $types = []): void
    {
        foreach ($types as $name => $callbacks) {
            [$constructor, $serializer] = (is_array($callbacks) ? $callbacks : [$callbacks, null]);

            static::registerEnumType($name, $constructor, $serializer);
        }
    }

    /**
     * Registers an enumerable handler
     *
     * @param string        $name
     * @param callable      $constructor Receives: value, platform
     * @param callable|null $serializer  Receives: value, platform
     *
     * @throws InvalidArgumentException|Exception
     */
    public static function registerEnumType(string $name, callable $constructor, callable $serializer = null): void
    {
        if (static::hasType($name)) {
            return;
        }

        $serializer = $serializer ?? fn($value) => ($value === null) ? null : (string)$value;

        // Register and customize the type
        static::addType($name, static::class);

        /** @var EnumerationBridge $type */
        $type              = static::getType($name);
        $type->name        = $name;
        $type->constructor = $constructor;
        $type->serializer  = $serializer;
    }

    public function getName(): string
    {
        return $this->name ?: 'enum';
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getVarcharTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        return ($this->constructor)($value, $platform);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return ($this->serializer)($value, $platform);
    }
}
