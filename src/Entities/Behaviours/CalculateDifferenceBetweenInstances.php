<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities\Behaviours;

use Somnambulist\Components\Domain\Utils\ObjectDiff;

/**
 * Trait CalculateDifferenceBetweenInstances
 *
 * @package    Somnambulist\Components\Domain\Entities\Behaviours
 * @subpackage Somnambulist\Components\Domain\Entities\Behaviours\CalculateDifferenceBetweenInstances
 */
trait CalculateDifferenceBetweenInstances
{
    public function diff(object $that): array
    {
        return (new ObjectDiff())->diff($this, $that);
    }
}
