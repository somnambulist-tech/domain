<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Support\Stubs\Events;

use Somnambulist\Components\Domain\Events\AbstractEvent;

class GroupPropertyEvent extends AbstractEvent
{

    protected string $group = 'my_group';
}
