<?php declare(strict_types=1);

namespace Somnambulist\Components\Queries;

use Somnambulist\Components\Queries\Responses\AbstractQueryResponse;

interface QueryBus
{
    /**
     * Executes a query returning the result
     *
     * @param AbstractQuery $query
     *
     * @return mixed|AbstractQueryResponse
     */
    public function execute(AbstractQuery $query): mixed;
}
