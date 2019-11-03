<?php declare(strict_types=1);

namespace Somnambulist\Domain\Doctrine\Behaviours\QueryBuilder;

use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Trait HasGroupByColumn
 *
 * @package    Somnambulist\Domain\Doctrine\Behaviours\QueryBuilder
 * @subpackage Somnambulist\Domain\Doctrine\Behaviours\QueryBuilder\HasGroupByColumn
 */
trait HasGroupByColumn
{

    /**
     * Returns true if the column is already defined in the query builder
     *
     * @param QueryBuilder $qb
     * @param string       $column
     *
     * @return bool
     */
    public function hasColumnInGroupBy(QueryBuilder $qb, string $column): bool
    {
        return in_array($column, $qb->getQueryPart('groupBy'));
    }
}
