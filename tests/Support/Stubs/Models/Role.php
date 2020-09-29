<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Support\Stubs\Models;

use Somnambulist\Components\Domain\Entities\AbstractEnumeration;

/**
 * Class Role
 *
 * @package    Somnambulist\Components\Domain\Tests\Support\Stubs\Models
 * @subpackage Somnambulist\Components\Domain\Tests\Support\Stubs\Models\Role
 */
final class Role extends AbstractEnumeration
{

    const LEADER    = 'leader';
    const MEMBER    = 'member';
    const MODERATOR = 'moderator';
}
