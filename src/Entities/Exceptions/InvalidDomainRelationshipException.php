<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities\Exceptions;

use function sprintf;

/**
 * Class InvalidDomainRelationshipException
 *
 * Exception for when operating on entity relationships is invalid.
 *
 * @package    Somnambulist\Components\Domain\Entities\Exceptions
 * @subpackage Somnambulist\Components\Domain\Entities\Exceptions\InvalidDomainRelationshipException
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

    /**
     * @param string     $type
     * @param int|string $id
     *
     * @return InvalidDomainRelationshipException
     */
    public static function entityRelationshipAlreadyExists(string $type, $id): self
    {
        return new static(sprintf('A record of type "%s" already exists for "%s"', $type, $id));
    }

    /**
     * @param string     $type
     * @param int|string $id
     * @param string     $related
     * @param int|string $relatedId
     *
     * @return InvalidDomainRelationshipException
     */
    public static function cannotChangeEntityRelationship(string $type, $id, string $related, $relatedId): self
    {
        return new static(
            sprintf(
                'Entity "%s" with id "%s" is already associated with "%s" with id "%s"',
                $type, $id, $related, $relatedId
            )
        );
    }
}
