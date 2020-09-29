<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Support\Stubs\Events;

use Somnambulist\Components\Domain\Events\AbstractEvent;

/**
 * Class UserRegistrationComplete
 *
 * @package    Somnambulist\Components\Domain\Tests\Support\Stubs\Events
 * @subpackage Somnambulist\Components\Domain\Tests\Support\Stubs\Events\UserRegistrationComplete
 */
class UserRegistrationComplete extends AbstractEvent
{

    protected string $group = 'user';
    
}
