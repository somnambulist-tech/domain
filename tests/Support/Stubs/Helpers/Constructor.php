<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Support\Stubs\Helpers;

use InvalidArgumentException;
use Somnambulist\Components\Tests\Support\Stubs\Enum\Gender;

class Constructor
{
    public function __invoke($value): ?Gender
    {
        if (null === $value) {
            return null;
        }

        if (null !== $gender = Gender::memberOrNullByValue($value)) {
            return $gender;
        }

        throw new InvalidArgumentException(sprintf('"%s" not valid for "%s"', $value, Gender::class));
    }
}
