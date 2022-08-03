<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Support\Stubs\EventHandlers;

use Somnambulist\Components\Tests\Support\Stubs\Events\UserCreated;

class UserCreatedEventHandler
{
    public function __invoke(UserCreated $event): void
    {

    }
}
