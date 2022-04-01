<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities\Types\Identity;

use Assert\Assert;
use Somnambulist\Components\Domain\Entities\AbstractValueObject;

/**
 * Class AbstractIdentity
 *
 * Base class that allows extension to provide a typed "identity" in an aggregate / entity.
 * The UUID type extends this to provide a concrete identity that is a typed UUID.
 *
 * @package Somnambulist\Components\Domain\Entities\Types\Identity
 * @subpackage Somnambulist\Components\Domain\Entities\Types\Identity\AbstractIdentity
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
