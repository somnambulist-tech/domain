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
            trigger_deprecation('somnambulist/domain', '4.6.0', 'Dynamic getters have been deprecated. Implement concrete methods instead.');

            $name = Str::replaceFirst('get', '', $name);

            return $this->criteria->only(Str::snake($name), Str::ucfirst($name), $name)->first() ?? null;
        }

        throw new BadMethodCallException(sprintf('Method not found for "%s"', $name));
    }

    public function getCriteria(): FrozenCollection
    {
        trigger_deprecation('somnambulist/domain', '4.6.0', 'Use criteria() instead');

        return $this->criteria();
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
