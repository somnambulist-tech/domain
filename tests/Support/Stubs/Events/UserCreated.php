<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Support\Stubs\Events;

use Somnambulist\Domain\Events\AbstractEvent;

/**
 * Class UserCreated
 *
 * @package    Somnambulist\Domain\Tests\Support\Stubs\Events
 * @subpackage Somnambulist\Domain\Tests\Support\Stubs\Events\UserCreated
 */
class UserCreated extends AbstractEvent
{

    protected string $group = 'user';

}
