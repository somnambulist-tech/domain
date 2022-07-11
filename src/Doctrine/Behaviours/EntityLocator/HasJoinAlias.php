<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Behaviours\EntityLocator;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;

/**
 * Adapted from the solution provided by:
 *
 * @author zuzuleinen via Stackoverflow
 * @link https://stackoverflow.com/a/27020853
 */
trait HasJoinAlias
{
    public function hasJoinAlias(QueryBuilder $qb, string $alias): bool
    {
        $joinDqlParts = $qb->getDQLParts()['join'];

        /* @var Join $join */
        foreach ($joinDqlParts as $joins) {
            foreach ($joins as $join) {
                if ($join->getAlias() === $alias) {
                    return true;
                }
            }
        }

        return false;
    }
}
