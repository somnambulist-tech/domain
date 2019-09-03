<?php declare(strict_types=1);

namespace Somnambulist\Domain\Doctrine;

use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * Class Paginator
 *
 * @package    Somnambulist\Domain\Doctrine
 * @subpackage Somnambulist\Domain\Doctrine\Paginator
 */
class Paginator
{

    /**
     * @var Query
     */
    private $query;

    /**
     * Constructor.
     *
     * @param Query $query
     */
    public function __construct(Query $query)
    {
        $this->query = $query;
    }

    public function paginate(int $perPage = 20, int $page = 1, bool $fetchJoinCollection = true): Pagerfanta
    {
        return (new Pagerfanta(new DoctrineORMAdapter($this->query, $fetchJoinCollection)))
            ->setCurrentPage($page)
            ->setMaxPerPage($perPage)
        ;
    }
}
