<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Behaviours\QueryBuilder;

use Doctrine\DBAL\Query\QueryBuilder;

trait HasGroupByColumn
{
    public function hasColumnInGroupBy(QueryBuilder $qb, string $column): bool
    {
        return in_array($column, $qb->getQueryPart('groupBy'));
    }
}
