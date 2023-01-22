<?php declare(strict_types=1);

namespace Somnambulist\Components\Queries;

use Somnambulist\Components\Collection\FrozenCollection;
use Somnambulist\Components\Queries\Behaviours\CanIncludeMetaData;
use Somnambulist\Components\Queries\Behaviours\CanIncludeRelatedData;
use Somnambulist\Components\Queries\Behaviours\CanPaginateQuery;
use Somnambulist\Components\Queries\Behaviours\CanSortQuery;
use Somnambulist\Components\Queries\Contracts\Paginatable;
use Somnambulist\Components\Queries\Contracts\Sortable;

abstract class AbstractPaginatableQuery extends AbstractQuery implements Paginatable, Sortable
{
    use CanIncludeRelatedData;
    use CanIncludeMetaData;
    use CanPaginateQuery;
    use CanSortQuery;

    private readonly FrozenCollection $criteria;

    public function __construct(array $criteria = [], array $orderBy = [], int $page = 1, int $perPage = 30)
    {
        $this->criteria = new FrozenCollection($criteria);
        $this->orderBy  = new FrozenCollection($orderBy);
        $this->page     = $page;
        $this->perPage  = $perPage;
    }

    public function criteria(): FrozenCollection
    {
        return $this->criteria;
    }

    public function get(string $key, mixed $default): mixed
    {
        return $this->criteria()->get($key, $default);
    }

    public function has(string $key): bool
    {
        return $this->criteria()->has($key);
    }
}
