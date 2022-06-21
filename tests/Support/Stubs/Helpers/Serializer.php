<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Support\Stubs\Helpers;

use Somnambulist\Components\Tests\Support\Stubs\Enum\Gender;

class Serializer
{

    /**
     * @param Gender $value
     *
     * @return string
     */
    public function __invoke($value) {
        return $value->value();
    }
}
