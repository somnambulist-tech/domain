<?php declare(strict_types=1);

namespace Somnambulist\Components\Queries;

use Somnambulist\Components\Models\Types\Identity\AbstractIdentity;

abstract readonly class AbstractFindByIdQuery extends AbstractQuery
{
    public function __construct(private AbstractIdentity $id)
    {
    }

    public function __toString(): string
    {
        return (string)$this->id;
    }

    public function id(): AbstractIdentity
    {
        return $this->id;
    }
}
