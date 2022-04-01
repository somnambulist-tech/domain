<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities\Contracts;

/**
 * Class HasEqualityInterface
 *
 * @package    Somnambulist\Components\Domain\Entities\Contracts
 * @subpackage Somnambulist\Components\Domain\Entities\Contracts\HasEqualityInterface
 */
interface CanTestEquality
{
    public function equals(object $object): bool;
}
