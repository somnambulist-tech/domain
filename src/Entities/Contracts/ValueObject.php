<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities\Contracts;

/**
 * Interface ValueObjectInterface
 *
 * @package    Somnambulist\Components\Domain\Entities\Contracts
 * @subpackage Somnambulist\Components\Domain\Entities\Contracts\ValueObjectInterface
 */
interface ValueObject extends CanCastToString, CanTestEquality
{

}
