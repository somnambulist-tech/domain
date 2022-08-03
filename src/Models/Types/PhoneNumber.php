<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types;

use Assert\Assert;
use Somnambulist\Components\Models\AbstractValueObject;

/**
 * Represents a phone number in the domain
 *
 * Phone numbers are stored internally using E164 format. You should use a library
 * such as Giggsey PhoneNumber to convert a local string to E164 - the full
 * international format including leading +
 *
 * Note: allow sufficient storage space for the number, and always store the number
 * as a string and never an integer.
 */
final class PhoneNumber extends AbstractValueObject
{
    public function __construct(private readonly string $value)
    {
        Assert::that($value, null, 'phone number')->notEmpty()->e164();
    }

    public function toString(): string
    {
        return $this->value;
    }
}
