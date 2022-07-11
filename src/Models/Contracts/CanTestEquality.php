<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Contracts;

interface CanTestEquality
{
    public function equals(object $object): bool;
}
