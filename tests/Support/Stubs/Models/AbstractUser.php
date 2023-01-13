<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Support\Stubs\Models;

abstract class AbstractUser
{
    private ?int $id = null;
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
