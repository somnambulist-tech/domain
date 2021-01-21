<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Queries;

use BadMethodCallException;
use IlluminateAgnostic\Str\Support\Str;
use Somnambulist\Components\Collection\FrozenCollection;
use Somnambulist\Components\Domain\Queries\Behaviours\CanIncludeRelatedData;
use Somnambulist\Components\Domain\Queries\Behaviours\CanPaginateQuery;
use Somnambulist\Components\Domain\Queries\Behaviours\CanSortQuery;

/**
 * Class AbstractPaginatableQuery
 *
 * Allows accessing criteria keys by methods starting with "getXXX". The following
 * attribute names will be tried: without get, lcfirst, snake case. For example:
 * an attribute named user_group can be accessed via: getUserGroup. The following
 * combinations will be tried: UserGroup, userGroup and user_group.
 *
 * If the attribute is not found, null will be returned. Invalid method calls will
 * raise an exception.
 *
 * @package    Somnambulist\Components\Domain\Queries
 * @subpackage Somnambulist\Components\Domain\Queries\AbstractPaginatableQuery
 */
abstract class AbstractPaginatableQuery extends AbstractQuery
{

    use CanIncludeRelatedData;
    use CanPaginateQuery;
    use CanSortQuery;

    private FrozenCollection $criteria;

    public function __construct(array $criteria = [], array $orderBy = [], int $page = 1, int $perPage = 30)
    {
        $this->criteria = new FrozenCollection($criteria);
        $this->orderBy  = new FrozenCollection($orderBy);
        $this->page     = $page;
        $this->perPage  = $perPage;
    }

    public function __call($name, $arguments)
    {
        if (Str::startsWith($name, 'get')) {
            $name = Str::replaceFirst('get', '', $name);

            return $this->criteria->only(Str::snake($name), Str::ucfirst($name), $name)->first() ?? null;
        }

        throw new BadMethodCallException(sprintf('Method not found for "%s"', $name));
    }

    public function getCriteria(): FrozenCollection
    {
        return $this->criteria;
    }
}
