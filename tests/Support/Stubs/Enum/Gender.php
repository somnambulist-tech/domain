<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Support\Stubs\Enum;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * @method static Gender MALE()
 * @method static Gender FEMALE()
 */
class Gender extends AbstractEnumeration
{

    const MALE = 'male';
    const FEMALE = 'female';

}
