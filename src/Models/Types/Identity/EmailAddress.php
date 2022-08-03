<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types\Identity;

use Assert\Assert;
use Somnambulist\Components\Models\AbstractValueObject;

/**
 * Represents an email address in the domain
 */
final class EmailAddress extends AbstractValueObject
{
    public function __construct(private readonly string $value)
    {
        Assert::that($value, null, 'email')->notEmpty()->email()->maxLength(100);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function account(): string
    {
        return mb_substr($this->value, 0, mb_strpos($this->value, '@'));
    }

    public function domain(): string
    {
        return mb_substr($this->value, mb_strpos($this->value, '@') + 1);
    }
}
