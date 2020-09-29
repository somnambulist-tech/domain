<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Doctrine\Behaviours\QueryBuilder;

use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Trait HasGroupByColumn
 *
 * @package    Somnambulist\Components\Domain\Doctrine\Behaviours\QueryBuilder
 * @subpackage Somnambulist\Components\Domain\Doctrine\Behaviours\QueryBuilder\HasGroupByColumn
 */
trait HasGroupByColumn
{

    public function hasColumnInGroupBy(QueryBuilder $qb, string $column): bool
    {
        return in_array($column, $qb->getQueryPart('groupBy'));
    }
}
