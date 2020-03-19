<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types;

use Assert\Assert;
use Somnambulist\Domain\Entities\AbstractValueObject;

/**
 * Class AbstractType
 *
 * Instead of an enumeration, allows for a typed "type" to be used. For example, your
 * API requires that an entity has a type e.g. AddressType, but you do not want a hard
 * enumeration that requires code changes to add new values. This type can be extended
 * to provide that typing.
 *
 * To use, extend this class and then create either a Type mapping via an embeddable
 * Doctrine configuration, or use the EnumerationBridge to map a custom type.
 *
 * @package Somnambulist\Domain\Entities\Types
 * @subpackage Somnambulist\Domain\Entities\Types\AbstractType
 */
abstract class AbstractType extends AbstractValueObject
{

    protected string $value;

    public function __construct(string $type)
    {
        Assert::that($type, null, 'type')->notEmpty()->maxLength(50);

        $this->value = $type;
    }

    public static function default(): self
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
