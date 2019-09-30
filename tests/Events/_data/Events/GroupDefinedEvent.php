<?php

namespace Events;

use Somnambulist\Domain\Events\AbstractDomainEvent;

/**
 * Class GroupDefinedEvent
 *
 * @package    Events
 * @subpackage Events\GroupDefinedEvent
 */
class GroupDefinedEvent extends AbstractDomainEvent
{

    const NOTIFICATION_GROUP = 'my_group';
}
