<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Behaviours\QueryBuilder;

use Doctrine\DBAL\Query\QueryBuilder;
use Somnambulist\Components\Utils\EntityAccessor;
use function method_exists;

trait HasSelectColumn
{
    public function hasColumnInSelect(QueryBuilder $qb, string $column): bool
    {
        if (method_exists($qb, 'getQueryPart')) {
            $columns = $qb->getQueryPart('select');
        } else {
            $columns = EntityAccessor::get($qb, 'select');
        }

        return in_array($column, $columns);
    }
}
