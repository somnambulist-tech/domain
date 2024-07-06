<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Support\Stubs\Models;

abstract class AbstractEntity
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
