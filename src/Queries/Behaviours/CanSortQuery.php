<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Queries\Behaviours;

use Somnambulist\Components\Collection\FrozenCollection;
use function class_alias;

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
        trigger_deprecation('somnambulist/domain', '4.6.0', 'Use orderBy() instead');

        return $this->orderBy();
    }

    public function orderBy(): FrozenCollection
    {
        return $this->orderBy;
    }
}

class_alias(CanSortQuery::class, 'Somnambulist\Components\Domain\Queries\Behaviours\CanOrderQuery');
