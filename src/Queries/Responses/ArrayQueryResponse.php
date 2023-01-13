<?php declare(strict_types=1);

namespace Somnambulist\Components\Queries\Responses;

class ArrayQueryResponse extends AbstractQueryResponse
{
    public function __construct(array $data, QueryResponseStatus $status)
    {
        $this->data = $data;
        $this->status = $status;
    }
}
