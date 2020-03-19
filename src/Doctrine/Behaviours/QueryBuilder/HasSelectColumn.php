<?php declare(strict_types=1);

namespace Somnambulist\Domain\Doctrine\Behaviours\QueryBuilder;

use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Trait HasSelectColumn
 *
 * @package    Somnambulist\Domain\Doctrine\Behaviours\QueryBuilder
 * @subpackage Somnambulist\Domain\Doctrine\Behaviours\QueryBuilder\HasSelectColumn
 */
trait HasSelectColumn
{

    public function hasColumnInSelect(QueryBuilder $qb, string $column): bool
    {
        return in_array($column, $qb->getQueryPart('select'));
    }
}
