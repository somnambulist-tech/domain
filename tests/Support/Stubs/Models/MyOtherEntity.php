<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Support\Stubs\Models;

use Somnambulist\Components\Domain\Entities\Types\DateTime\DateTime;

class MyOtherEntity
{

    protected ?int $id = null;
    protected MyEntity $myEntity;
    protected string $name;
    protected string $another;
    protected DateTime $createdAt;

    public function __construct(MyEntity $myEntity, string $name, string $another, DateTime $createdAt)
    {
        $this->myEntity  = $myEntity;
        $this->name      = $name;
        $this->another   = $another;
        $this->createdAt = $createdAt;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAnother(): string
    {
        return $this->another;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
}
