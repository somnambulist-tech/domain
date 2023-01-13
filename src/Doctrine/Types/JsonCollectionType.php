<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Somnambulist\Components\Collection\MutableCollection as Collection;

/**
 * Variation of the JSON type that instead expands to an MutableCollection instead
 * of an array. This allows all the collection methods to be used internally.
 */
class JsonCollectionType extends Type
{
    const TYPE_NAME = 'json_collection';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getJsonTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }
        if ($value instanceof Collection) {
            $value = $value->toArray();
        }

        return json_encode($value);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if ($value === null || $value === '') {
            return new Collection();
        }

        $value = (is_resource($value)) ? stream_get_contents($value) : $value;

        return new Collection(json_decode($value, true));
    }

    public function getName(): string
    {
        return static::TYPE_NAME;
    }
}
