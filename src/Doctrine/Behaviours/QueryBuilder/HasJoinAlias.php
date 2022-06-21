<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Behaviours\QueryBuilder;

use Doctrine\DBAL\Query\QueryBuilder;

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
        $parts = $qb->getQueryPart('join');

        foreach ($parts as $joins) {
            foreach ($joins as $join) {
                if ($join['joinAlias'] === $alias) {
                    return true;
                }
            }
        }

        return false;
    }
}
