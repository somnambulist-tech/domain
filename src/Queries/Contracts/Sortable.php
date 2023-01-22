<?php declare(strict_types=1);

namespace Somnambulist\Components\Queries\Contracts;

use Somnambulist\Components\Collection\FrozenCollection;

interface Sortable
{
    public function orderBy(): FrozenCollection;
}
