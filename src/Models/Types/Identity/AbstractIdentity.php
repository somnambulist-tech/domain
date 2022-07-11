<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types\Identity;

use Assert\Assert;
use Somnambulist\Components\Models\AbstractValueObject;

/**
 * A base identity type that uses UUIDs as identity
 *
 * Base class that allows extension to provide a typed "identity" in an aggregate / entity.
 * The UUID type extends this to provide a concrete identity that is a typed UUID.
 */
abstract class AbstractIdentity extends AbstractValueObject
{
    public function __construct(protected string $value)
    {
        Assert::that($value, null, 'uuid')->notEmpty()->uuid();
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function toUuid(): Uuid
    {
        return new Uuid($this->toString());
    }
}
