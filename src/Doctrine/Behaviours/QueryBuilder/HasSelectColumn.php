<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Behaviours\QueryBuilder;

use Doctrine\DBAL\Query\QueryBuilder;

trait HasSelectColumn
{
    public function hasColumnInSelect(QueryBuilder $qb, string $column): bool
    {
        return in_array($column, $qb->getQueryPart('select'));
    }
}
