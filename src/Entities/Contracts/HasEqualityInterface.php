<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Contracts;

/**
 * Class HasEqualityInterface
 *
 * @package    Somnambulist\Domain\Entities\Contracts
 * @subpackage Somnambulist\Domain\Entities\Contracts\HasEqualityInterface
 */
interface HasEqualityInterface
{

    /**
     * Returns true if the objects when compared can be considered to be equal
     *
     * @param object $object
     *
     * @return bool
     */
    public function equals(object $object): bool;
}
