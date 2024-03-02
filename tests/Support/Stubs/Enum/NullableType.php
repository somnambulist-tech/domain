<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Support\Stubs\Enum;

use Somnambulist\Components\Models\AbstractEnumeration;

/**
 * @method static NullableType UNKNOWN()
 * @method static NullableType PRESENT()
 * @method static NullableType ABSENT()
 */
class NullableType extends AbstractEnumeration
{
    const UNKNOWN = null;
    const PRESENT = 'present';
    const ABSENT  = 'absent';
}
