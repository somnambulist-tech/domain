<?php declare(strict_types=1);

namespace Somnambulist\Components\Queries\Responses;

use Somnambulist\Components\ReadModels\Model;

class ReadModelQueryResponse extends AbstractQueryResponse
{
    public function __construct(Model $data, QueryResponseStatus $status)
    {
        $this->data = $data;
        $this->status = $status;
    }
}
