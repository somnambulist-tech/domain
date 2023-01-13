<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Support\Stubs\Helpers;

use InvalidArgumentException;
use Somnambulist\Components\Tests\Support\Stubs\Enum\NullableType;

class NullableConstructor
{
    public function __invoke($value): mixed
    {
        if (null !== $enum = NullableType::memberOrNullByValue($value)) {
            return $enum;
        }

        throw new InvalidArgumentException(sprintf('"%s" not valid for "%s"', $value, NullableType::class));
    }
}
