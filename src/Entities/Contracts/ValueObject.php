<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Contracts;

/**
 * Interface ValueObjectInterface
 *
 * @package    Somnambulist\Domain\Entities\Contracts
 * @subpackage Somnambulist\Domain\Entities\Contracts\ValueObjectInterface
 */
interface ValueObject extends CanCastToString, CanTestEquality
{

}
