<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities\Contracts;

/**
 * Interface CanCastToString
 *
 * @package    Somnambulist\Components\Domain\Entities\Contracts
 * @subpackage Somnambulist\Components\Domain\Entities\Contracts\CanCastToString
 */
interface CanCastToString
{
    public function toString(): string;
}
