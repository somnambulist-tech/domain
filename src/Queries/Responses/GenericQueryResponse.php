<?php declare(strict_types=1);

namespace Somnambulist\Components\Queries\Responses;

class GenericQueryResponse extends AbstractQueryResponse
{
    public function __construct(mixed $data, QueryResponseStatus $status)
    {
        $this->data = $data;
        $this->status = $status;
    }
}
