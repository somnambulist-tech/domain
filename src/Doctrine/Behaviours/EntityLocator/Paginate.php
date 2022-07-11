<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Behaviours\EntityLocator;

use Doctrine\ORM\Query;
use Pagerfanta\Pagerfanta;
use Somnambulist\Components\Doctrine\Paginator;

trait Paginate
{
    public function paginate(Query $query, int $perPage, int $page = 1, bool $fetchJoinCollection = true): Pagerfanta
    {
        return Paginator::for($query)->paginate($perPage, $page, $fetchJoinCollection);
    }
}
