<?php declare(strict_types=1);

namespace Somnambulist\Domain\Doctrine\Behaviours\EntityLocator;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;

/**
 * Trait HasJoinAlias
 *
 * @author zuzuleinen via Stackoverflow
 * @link https://stackoverflow.com/a/27020853
 *
 * @package    Somnambulist\Domain\Doctrine\Behaviours\EntityLocator
 * @subpackage Somnambulist\Domain\Doctrine\Behaviours\EntityLocator\HasJoinAlias
 */
trait HasJoinAlias
{

    /**
     * Returns true if the join alias is already defined in the query builder
     *
     * @param QueryBuilder $qb
     * @param string       $alias
     *
     * @return bool
     */
    public function hasJoinAlias(QueryBuilder $qb, string $alias): bool
    {
        $joinDqlParts = $qb->getDQLParts()['join'];
        $exists       = false;

        /* @var Join $join */
        foreach ($joinDqlParts as $joins) {
            foreach ($joins as $join) {
                if ($join->getAlias() === $alias) {
                    $exists = true;
                    break 2;
                }
            }
        }

        return $exists;
    }
}
