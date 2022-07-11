<?php declare(strict_types=1);

namespace Somnambulist\Components\Queries\Behaviours;

trait CanPaginateQuery
{
    private int $page = 1;
    private int $perPage = 30;

    public function getPage(): int
    {
        trigger_deprecation('somnambulist/domain', '4.6.0', 'Use page() instead');

        return $this->page();
    }

    public function page(): int
    {
        return $this->page;
    }

    public function getPerPage(): int
    {
        trigger_deprecation('somnambulist/domain', '4.6.0', 'Use perPage() instead');

        return $this->perPage();
    }

    public function perPage(): int
    {
        return $this->perPage;
    }
}
