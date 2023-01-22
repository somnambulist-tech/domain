<?php declare(strict_types=1);

namespace Somnambulist\Components\Queries\Contracts;

use function class_alias;

interface UsesResponseClass
{
    public function responseClass(): string;
}

class_alias(UsesResponseClass::class, 'Somnambulist\Components\Queries\UsesResponseClass');
