<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Queries;

/**
 * Interface QueryBus
 *
 * @package    Somnambulist\Components\Domain\Queries
 * @subpackage Somnambulist\Components\Domain\Queries\QueryBus
 */
interface QueryBus
{
    /**
     * Executes a query returning the result
     *
     * @param AbstractQuery $query
     *
     * @return mixed
     */
    public function execute(AbstractQuery $query): mixed;
}
