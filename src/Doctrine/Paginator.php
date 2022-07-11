<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine;

use Doctrine\ORM\Query;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

class Paginator
{
    public function __construct(private Query $query)
    {
    }

    public static function for(Query $query): self
    {
        return new self($query);
    }

    public function paginate(int $perPage = 20, int $page = 1, bool $fetchJoinCollection = true): Pagerfanta
    {
        return (new Pagerfanta(new QueryAdapter($this->query, $fetchJoinCollection)))
            ->setCurrentPage($page)
            ->setMaxPerPage($perPage)
        ;
    }
}
