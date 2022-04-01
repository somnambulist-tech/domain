<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Doctrine\Behaviours\EntityLocator;

use Doctrine\ORM\Query;
use Pagerfanta\Pagerfanta;
use Somnambulist\Components\Domain\Doctrine\Paginator;

/**
 * Trait Paginate
 *
 * @package    Somnambulist\Components\Domain\Doctrine\Behaviours\EntityLocator
 * @subpackage Somnambulist\Components\Domain\Doctrine\Behaviours\EntityLocator\Paginate
 */
trait Paginate
{
    public function paginate(Query $query, int $perPage, int $page = 1, bool $fetchJoinCollection = true): Pagerfanta
    {
        return Paginator::for($query)->paginate($perPage, $page, $fetchJoinCollection);
    }
}
