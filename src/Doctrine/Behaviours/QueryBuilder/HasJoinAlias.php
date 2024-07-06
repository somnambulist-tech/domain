<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Behaviours\QueryBuilder;

use Doctrine\DBAL\Query\Join;
use Doctrine\DBAL\Query\QueryBuilder;
use Somnambulist\Components\Utils\EntityAccessor;
use function is_a;
use function method_exists;

/**
 * Adapted from the DQL solution provided by:
 *
 * @author zuzuleinen via Stackoverflow
 * @link https://stackoverflow.com/a/27020853
 */
trait HasJoinAlias
{
    public function hasJoinAlias(QueryBuilder $qb, string $alias): bool
    {
        if (method_exists($qb, 'getQueryPart')) {
            $parts = $qb->getQueryPart('join');
        } else {
            $parts = EntityAccessor::get($qb, 'join', $qb);
        }

        foreach ($parts as $joins) {
            foreach ($joins as $join) {
                if (
                    (is_array($join) && $join['joinAlias'] === $alias)
                    ||
                    (is_a($join, Join::class) && $join->alias === $alias)
                ) {
                    return true;
                }
            }
        }

        return false;
    }
}
