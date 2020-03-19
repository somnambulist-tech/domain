<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Support\Stubs\Events;

use Somnambulist\Domain\Events\AbstractEvent;

class GroupPropertyEvent extends AbstractEvent
{

    protected string $group = 'my_group';
}
