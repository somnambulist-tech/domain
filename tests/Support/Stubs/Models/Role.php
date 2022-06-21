<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Support\Stubs\Models;

use Somnambulist\Components\Models\AbstractEnumeration;

/**
 * Class Role
 *
 * @package    Somnambulist\Components\Tests\Support\Stubs\Models
 * @subpackage Somnambulist\Components\Tests\Support\Stubs\Models\Role
 */
final class Role extends AbstractEnumeration
{

    const LEADER    = 'leader';
    const MEMBER    = 'member';
    const MODERATOR = 'moderator';
}
