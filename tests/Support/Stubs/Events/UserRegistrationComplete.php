<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Support\Stubs\Events;

use Somnambulist\Domain\Events\AbstractEvent;

/**
 * Class UserRegistrationComplete
 *
 * @package    Somnambulist\Domain\Tests\Support\Stubs\Events
 * @subpackage Somnambulist\Domain\Tests\Support\Stubs\Events\UserRegistrationComplete
 */
class UserRegistrationComplete extends AbstractEvent
{

    protected string $group = 'user';
    
}
