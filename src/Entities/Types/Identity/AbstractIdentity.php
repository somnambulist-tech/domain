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

    protected string $value;

    public function __construct(string $uuid)
    {
        Assert::that($uuid, null, 'uuid')->notEmpty()->uuid();

        $this->value = $uuid;
    }

    public function toString(): string
    {
        return (string)$this->value;
    }

    public function toUuid(): Uuid
    {
        return new Uuid($this->toString());
    }
}
