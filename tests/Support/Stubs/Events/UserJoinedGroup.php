<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Support\Stubs\Events;

use Somnambulist\Components\Events\AbstractEvent;

class UserJoinedGroup extends AbstractEvent
{

    protected string $group = 'user';
}
