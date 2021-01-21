<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Somnambulist\Components\Collection\MutableCollection as Collection;

/**
 * Class JsonCollectionType
 *
 * Variation of the JSON type that instead expands to an ArrayCollection instead
 * of an array. This allows all the ArrayCollection methods to be used internally.
 *
 * @package    Somnambulist\Components\Domain\Doctrine\Types
 * @subpackage Somnambulist\Components\Domain\Doctrine\Types\JsonCollectionType
 */
class JsonCollectionType extends Type
{

    const TYPE_NAME = 'json_collection';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return $platform->getJsonTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }
        if ($value instanceof Collection) {
            $value = $value->toArray();
        }

        return json_encode($value);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value === '') {
            return new Collection();
        }

        $value = (is_resource($value)) ? stream_get_contents($value) : $value;

        return new Collection(json_decode($value, true));
    }

    public function getName()
    {
        return static::TYPE_NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return !$platform->hasNativeJsonType();
    }
}
