<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types\Identity;

use Assert\Assert;
use Somnambulist\Components\Models\AbstractValueObject;

/**
 * Represents an aggregate root in a different context e.g. event
 */
final class Aggregate extends AbstractValueObject
{
    public function __construct(private readonly string $class, private readonly string $identity)
    {
        Assert::lazy()->tryAll()
            ->that($class, 'class')->notEmpty()->maxLength(255)
            ->that($identity, 'identity')->notEmpty()->uuid()
            ->verifyNow()
        ;
    }

    public function toString(): string
    {
        return sprintf('%s:%s', $this->class, $this->identity);
    }

    public function class(): string
    {
        return $this->class;
    }

    public function identity(): string
    {
        return $this->identity;
    }
}
