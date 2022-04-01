<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities\Behaviours;

use Somnambulist\Components\Domain\Utils\EntityAccessor;

/**
 * Trait CastValueObjectToArray
 *
 * @package    Somnambulist\Components\Domain\Entities\Behaviours
 * @subpackage Somnambulist\Components\Domain\Entities\Behaviours\CastValueObjectToArray
 */
trait CastValueObjectToArray
{
    public function toArray(): array
    {
        return EntityAccessor::extract($this, ignoreStatic: true, recurseValues: true);
    }
}
