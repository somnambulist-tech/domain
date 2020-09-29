<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Doctrine\Behaviours\QueryBuilder;

use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Trait HasJoinAlias
 *
 * Adapted from the DQL solution provided by:
 * @author zuzuleinen via Stackoverflow
 * @link https://stackoverflow.com/a/27020853
 *
 * @package    Somnambulist\Components\Domain\Doctrine\Behaviours\QueryBuilder
 * @subpackage Somnambulist\Components\Domain\Doctrine\Behaviours\QueryBuilder\HasJoinAlias
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
