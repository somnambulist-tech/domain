<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types\Identity;

use Assert\Assert;
use Somnambulist\Domain\Entities\AbstractValueObject;

/**
 * Class AbstractIdentity
 *
 * Base class that allows extension to provide a typed "identity" in an aggregate / entity.
 * The UUID type extends this to provide a concrete identity that is a typed UUID.
 *
 * @package Somnambulist\Domain\Entities\Types\Identity
 * @subpackage Somnambulist\Domain\Entities\Types\Identity\AbstractIdentity
 */
abstract class AbstractIdentity extends AbstractValueObject
{

    /**
     * @var string
     */
    protected $value;

    /**
     * Constructor.
     *
     * @param string $uuid
     */
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
        return new Uuid($this->value);
    }
}
