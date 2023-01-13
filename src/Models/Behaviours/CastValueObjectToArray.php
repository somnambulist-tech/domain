<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Behaviours;

use Somnambulist\Components\Utils\EntityAccessor;

trait CastValueObjectToArray
{
    public function toArray(): array
    {
        return EntityAccessor::extract($this, recurseValues: true);
    }
}
