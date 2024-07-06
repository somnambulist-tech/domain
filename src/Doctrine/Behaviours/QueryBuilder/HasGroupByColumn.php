<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Behaviours\QueryBuilder;

use Doctrine\DBAL\Query\QueryBuilder;
use Somnambulist\Components\Utils\EntityAccessor;
use function method_exists;

trait HasGroupByColumn
{
    public function hasColumnInGroupBy(QueryBuilder $qb, string $column): bool
    {
        if (method_exists($qb, 'getQueryPart')) {
            $columns = $qb->getQueryPart('groupBy');
        } else {
            $columns = EntityAccessor::get($qb, 'groupBy');
        }

        return in_array($column, $columns);
    }
}
