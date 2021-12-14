<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Queries\Behaviours;

/**
 * Trait CanPaginateQuery
 *
 * @package Somnambulist\Components\Domain\Queries\Behaviours
 * @subpackage Somnambulist\Components\Domain\Queries\Behaviours\CanPaginateQuery
 */
trait CanPaginateQuery
{
    private int $page = 1;
    private int $perPage = 30;

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }
}
