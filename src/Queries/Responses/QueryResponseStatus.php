<?php declare(strict_types=1);

namespace Somnambulist\Components\Queries\Responses;

use Throwable;
use function is_null;

final class QueryResponseStatus
{
    public readonly bool $success;

    public function __construct(public readonly ?Throwable $error)
    {
        $this->success = is_null($this->error);
    }

    public function success(): bool
    {
        return true === $this->success;
    }

    public function failed(): bool
    {
        return false === $this->success;
    }

    public function error(): ?Throwable
    {
        return $this->error;
    }
}
