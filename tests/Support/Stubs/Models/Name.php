<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Support\Stubs\Models;

use Assert\Assert;
use Somnambulist\Components\Models\AbstractValueObject;

final readonly class Name extends AbstractValueObject
{
    private string $value;

    public function __construct(string $name)
    {
        Assert::that($name, null, 'name')->notNull()->notEmpty()->maxLength(255);

        $this->value = $name;
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
