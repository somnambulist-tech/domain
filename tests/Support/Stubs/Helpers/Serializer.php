<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Support\Stubs\Helpers;

use Somnambulist\Components\Tests\Support\Stubs\Enum\Gender;

class Serializer
{
    public function __invoke(Gender $value): string
    {
        return $value->value();
    }
}
