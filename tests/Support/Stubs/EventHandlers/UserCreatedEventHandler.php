<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Support\Stubs\EventHandlers;

use Somnambulist\Components\Domain\Tests\Support\Stubs\Events\UserCreated;

/**
 * Class UserCreatedEventHandler
 *
 * @package    Somnambulist\Components\Domain\Tests\Support\Stubs\EventHandlers
 * @subpackage Somnambulist\Components\Domain\Tests\Support\Stubs\EventHandlers\UserCreatedEventHandler
 */
class UserCreatedEventHandler
{
    public function __invoke(UserCreated $event): void
    {

    }
}
