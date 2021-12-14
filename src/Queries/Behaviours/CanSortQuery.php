<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Queries\Behaviours;

use Somnambulist\Components\Collection\FrozenCollection;

/**
 * Trait CanSortQuery
 *
 * @package    Somnambulist\Components\Domain\Queries\Behaviours
 * @subpackage Somnambulist\Components\Domain\Queries\Behaviours\CanSortQuery
 */
trait CanSortQuery
{
    private FrozenCollection $orderBy;

    public function getOrderBy(): FrozenCollection
    {
        return $this->orderBy;
    }
}
