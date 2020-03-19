<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Contracts;

/**
 * Class HasEqualityInterface
 *
 * @package    Somnambulist\Domain\Entities\Contracts
 * @subpackage Somnambulist\Domain\Entities\Contracts\HasEqualityInterface
 */
interface CanTestEquality
{

    public function equals(object $object): bool;
}
