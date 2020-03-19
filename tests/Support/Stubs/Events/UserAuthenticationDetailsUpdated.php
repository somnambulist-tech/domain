<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Support\Stubs\Events;

use Somnambulist\Domain\Events\AbstractEvent;

/**
 * Class UserAuthenticationDetailsUpdated
 *
 * @package    Somnambulist\Domain\Tests\Support\Stubs\Events
 * @subpackage Somnambulist\Domain\Tests\Support\Stubs\Events\UserAuthenticationDetailsUpdated
 */
class UserAuthenticationDetailsUpdated extends AbstractEvent
{

    protected string $group = 'user';
    
}
