<?php declare(strict_types=1);

namespace Somnambulist\Domain\Queries;

/**
 * Interface QueryBus
 *
 * @package    Somnambulist\Domain\Queries
 * @subpackage Somnambulist\Domain\Queries\QueryBus
 */
interface QueryBus
{

    /**
     * Executes a query returning the result
     *
     * @param AbstractQuery $query
     *
     * @return mixed
     * @deprecated use execute, will be removed in 3.0
     */
    public function query(AbstractQuery $query);

    /**
     * Executes a query returning the result
     *
     * @param AbstractQuery $query
     *
     * @return mixed
     */
    public function execute(AbstractQuery $query);
}
