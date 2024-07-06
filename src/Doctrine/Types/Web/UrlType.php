<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Types\Web;

use Assert\Assert;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Exception\ValueNotConvertible;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;
use Somnambulist\Components\Models\Types\Web\Url;

/**
 * Store URL ValueObjects as strings and re-hydrate, without needing to use an embeddable.
 */
class UrlType extends Type
{
    public const NAME = 'url';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof Url) {
            return $value;
        }

        try {
            $url = new Url($value);
        } catch (InvalidArgumentException) {
            throw ValueNotConvertible::new($value, static::NAME);
        }

        return $url;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (empty($value)) {
            return null;
        }

        try {
            if ($value instanceof Url || Assert::that($value)->url()) {
                return (string)$value;
            }
        } catch (InvalidArgumentException) {

        }

        throw ValueNotConvertible::new($value, static::NAME);
    }

    public function getName(): string
    {
        return static::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
