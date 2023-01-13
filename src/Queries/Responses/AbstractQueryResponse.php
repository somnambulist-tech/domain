<?php declare(strict_types=1);

namespace Somnambulist\Components\Queries\Responses;

abstract class AbstractQueryResponse
{
    protected mixed $data;
    protected QueryResponseStatus $status;

    public function __set($name, $value): void
    {
    }

    public function __unset($name): void
    {
    }

    public function data(): mixed
    {
        return $this->data;
    }

    public function status(): QueryResponseStatus
    {
        return $this->status;
    }
}
