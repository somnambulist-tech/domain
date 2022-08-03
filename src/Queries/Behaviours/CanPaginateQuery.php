<?php declare(strict_types=1);

namespace Somnambulist\Components\Queries\Behaviours;

trait CanPaginateQuery
{
    private readonly int $page;
    private readonly int $perPage;

    public function page(): int
    {
        return $this->page;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }
}
