<?php declare(strict_types=1);

namespace Somnambulist\Components\Queries\Contracts;

interface Paginatable
{
    public function page(): int;

    public function perPage(): int;
}
