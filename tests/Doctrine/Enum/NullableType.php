<?php

namespace Somnambulist\Domain\Tests\Doctrine\Enum;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * Class NullableType
 *
 * @package    Somnambulist\Tests\DoctrineEnumBridge\Enum
 * @subpackage Somnambulist\Tests\DoctrineEnumBridge\Enum\NullableType
 *
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
