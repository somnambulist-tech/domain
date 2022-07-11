<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Exceptions;

use function sprintf;

/**
 * Exception for when operating on entity relationships is invalid.
 *
 * @codeCoverageIgnore
 */
class InvalidDomainRelationshipException extends InvalidDomainStateException
{
    public static function cannotAddChildToEntity(string $type): self
    {
        return new static(sprintf('Entity "%s" does not support children', $type));
    }

    public static function cannotRemoveChildFromEntity(string $type): self
    {
        return new static(sprintf('Entity "%s" does not support children', $type));
    }

    public static function cannotAddParentToEntity(string $type): self
    {
        return new static(sprintf('Entity "%s" does not support a parent', $type));
    }

    public static function cannotRemoveParentFromEntity(string $type): self
    {
        return new static(sprintf('Entity "%s" does not support removing a parent', $type));
    }

    public static function entityRelationshipAlreadyExists(string $type, mixed $id): self
    {
        return new static(sprintf('A record of type "%s" already exists for "%s"', $type, $id));
    }

    public static function cannotChangeEntityRelationship(string $type, mixed $id, string $related, mixed $relatedId): self
    {
        return new static(
            sprintf(
                'Entity "%s" with id "%s" is already associated with "%s" with id "%s"',
                $type, $id, $related, $relatedId
            )
        );
    }
}
