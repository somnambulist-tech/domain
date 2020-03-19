<?php declare(strict_types=1);

namespace Somnambulist\Domain\Events;

/**
 * Interface EventBus
 *
 * @package    Somnambulist\Domain\Events
 * @subpackage Somnambulist\Domain\Events\EventBus
 */
interface EventBus
{

    public function notify(AbstractEvent $event): void;
}
