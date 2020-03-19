<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Support\Stubs\Events;

use Somnambulist\Domain\Events\AbstractEvent;

/**
 * Class UserLeftGroup
 *
 * @package    Somnambulist\Domain\Tests\Support\Stubs\Events
 * @subpackage Somnambulist\Domain\Tests\Support\Stubs\Events\UserLeftGroup
 */
class UserLeftGroup extends AbstractEvent
{

    protected string $group = 'user';
}
