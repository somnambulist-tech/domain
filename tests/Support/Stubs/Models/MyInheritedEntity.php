<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Support\Stubs\Models;

class MyInheritedEntity extends AbstractEntity
{

    private string $id;

    public function __construct(string $id, string $name)
    {
        $this->id = $id;

        parent::__construct($name);
    }
}
