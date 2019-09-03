<?php declare(strict_types=1);

namespace Somnambulist\Domain\Doctrine\Behaviours\EntityLocator;

use Doctrine\ORM\Query;
use Pagerfanta\Pagerfanta;
use Somnambulist\Domain\Doctrine\Paginator;

/**
 * Trait Paginate
 *
 * @package    Somnambulist\Domain\Doctrine\Behaviours\EntityLocator
 * @subpackage Somnambulist\Domain\Doctrine\Behaviours\EntityLocator\Paginate
 */
trait Paginate
{

    /**
     * @param Query $query
     * @param int   $perPage
     * @param int   $page
     * @param bool  $fetchJoinCollection
     *
     * @return Pagerfanta
     */
    public function paginate(Query $query, int $perPage, int $page = 1, bool $fetchJoinCollection = true): Pagerfanta
    {
        return (new Paginator($query))->paginate($perPage, $page, $fetchJoinCollection);
    }
}
