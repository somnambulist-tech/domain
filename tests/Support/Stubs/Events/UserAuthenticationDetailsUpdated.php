<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Support\Stubs\Events;

use Somnambulist\Components\Events\AbstractEvent;

/**
 * Class UserAuthenticationDetailsUpdated
 *
 * @package    Somnambulist\Components\Tests\Support\Stubs\Events
 * @subpackage Somnambulist\Components\Tests\Support\Stubs\Events\UserAuthenticationDetailsUpdated
 */
class UserAuthenticationDetailsUpdated extends AbstractEvent
{

    protected string $group = 'user';
    
}
