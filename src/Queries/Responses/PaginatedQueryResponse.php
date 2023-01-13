<?php declare(strict_types=1);

namespace Somnambulist\Components\Queries\Responses;

use Countable;
use IteratorAggregate;
use Pagerfanta\Pagerfanta;
use Traversable;

class PaginatedQueryResponse extends AbstractQueryResponse implements Countable, IteratorAggregate
{
    public function __construct(Pagerfanta $data, QueryResponseStatus $status)
    {
        $this->data = $data;
        $this->status = $status;
    }

    public function getIterator(): Traversable
    {
        return $this->data;
    }

    public function count(): int
    {
        return $this->data->count();
    }
}
