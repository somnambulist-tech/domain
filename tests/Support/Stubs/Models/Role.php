<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Support\Stubs\Models;

use Somnambulist\Domain\Entities\AbstractEnumeration;

/**
 * Class Role
 *
 * @package    Somnambulist\Domain\Tests\Support\Stubs\Models
 * @subpackage Somnambulist\Domain\Tests\Support\Stubs\Models\Role
 */
final class Role extends AbstractEnumeration
{

    const LEADER    = 'leader';
    const MEMBER    = 'member';
    const MODERATOR = 'moderator';
}
