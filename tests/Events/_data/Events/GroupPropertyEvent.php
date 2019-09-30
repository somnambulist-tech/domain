<?php

namespace Events;

use Somnambulist\Domain\Events\AbstractDomainEvent;

/**
 * Class GroupPropertyEvent
 *
 * @package    Events
 * @subpackage Events\GroupPropertyEvent
 */
class GroupPropertyEvent extends AbstractDomainEvent
{

    protected $group = 'my_group';
}
