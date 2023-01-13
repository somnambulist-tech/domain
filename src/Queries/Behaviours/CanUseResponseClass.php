<?php declare(strict_types=1);

namespace Somnambulist\Components\Queries\Behaviours;

use Somnambulist\Components\Queries\Responses\GenericQueryResponse;

trait CanUseResponseClass
{
    protected string $responseClass = GenericQueryResponse::class;

    public function responseClass(): string
    {
        return $this->responseClass;
    }
}
