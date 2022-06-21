<?php declare(strict_types=1);

namespace Somnambulist\Components\Queries;

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
