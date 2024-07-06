<?php declare(strict_types=1);

namespace Somnambulist\Components\Queries\Contracts;

interface UsesResponseClass
{
    public function responseClass(): string;
}
