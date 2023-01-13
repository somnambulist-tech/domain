<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Support\Stubs\Models;

use Somnambulist\Components\Models\AbstractEnumeration;

/**
 * @method static Role LEADER()
 * @method static Role MEMBER()
 * @method static Role MODERATOR()
 */
final class Role extends AbstractEnumeration
{

    const LEADER    = 'leader';
    const MEMBER    = 'member';
    const MODERATOR = 'moderator';
}
