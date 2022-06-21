<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Support\Stubs\Events;

use Somnambulist\Components\Events\AbstractEvent;

/**
 * Class UserLeftGroup
 *
 * @package    Somnambulist\Components\Tests\Support\Stubs\Events
 * @subpackage Somnambulist\Components\Tests\Support\Stubs\Events\UserLeftGroup
 */
class UserLeftGroup extends AbstractEvent
{

    protected string $group = 'user';
}
