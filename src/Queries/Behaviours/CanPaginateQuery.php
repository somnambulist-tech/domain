<?php declare(strict_types=1);

namespace Somnambulist\Domain\Queries\Behaviours;

/**
 * Trait CanPaginateQuery
 *
 * @package Somnambulist\Domain\Queries\Behaviours
 * @subpackage Somnambulist\Domain\Queries\Behaviours\CanPaginateQuery
 */
trait CanPaginateQuery
{

    /**
     * @var int
     */
    private $page = 1;

    /**
     * @var int
     */
    private $perPage = 30;

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }
}
