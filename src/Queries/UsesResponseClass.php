<?php declare(strict_types=1);

namespace Somnambulist\Components\Queries;

interface UsesResponseClass
{
    public function responseClass(): string;
}
