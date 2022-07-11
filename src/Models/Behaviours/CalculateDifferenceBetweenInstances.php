<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Behaviours;

use Somnambulist\Components\Utils\ObjectDiff;

trait CalculateDifferenceBetweenInstances
{
    public function diff(object $that): array
    {
        return (new ObjectDiff())->diff($this, $that);
    }
}
