<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Support\Stubs\Events;

use Somnambulist\Components\Events\AbstractEvent;

/**
 * Class UserJoinedGroup
 *
 * @package    Somnambulist\Components\Tests\Support\Stubs\Events
 * @subpackage Somnambulist\Components\Tests\Support\Stubs\Events\UserJoinedGroup
 */
class UserJoinedGroup extends AbstractEvent
{

    protected string $group = 'user';
}
