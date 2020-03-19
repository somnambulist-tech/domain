<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Contracts;

/**
 * Interface CanCastToString
 *
 * @package    Somnambulist\Domain\Entities\Contracts
 * @subpackage Somnambulist\Domain\Entities\Contracts\CanCastToString
 */
interface CanCastToString
{

    public function toString(): string;
}
