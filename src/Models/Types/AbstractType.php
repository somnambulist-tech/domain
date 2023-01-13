<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types;

use Assert\Assert;
use Somnambulist\Components\Models\AbstractValueObject;

/**
 * Represents a string type in the domain
 *
 * Instead of an enumeration, allows for a typed "type" to be used. For example, your
 * API requires that an entity has a type e.g. AddressType, but you do not want a hard
 * enumeration that requires code changes to add new values. This type can be extended
 * to provide that typing.
 *
 * To use, extend this class and then create either a Type mapping via an embeddable
 * Doctrine configuration, or use the EnumerationBridge to map a custom type.
 */
abstract class AbstractType extends AbstractValueObject
{
    public function __construct(private readonly string $value)
    {
        Assert::that($value, null, 'type')->notEmpty()->maxLength(50);
    }

    public static function default(): static
    {
        return new static('default');
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function type(): string
    {
        return $this->value;
    }
}
