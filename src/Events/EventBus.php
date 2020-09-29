<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Events;

/**
 * Interface EventBus
 *
 * @package    Somnambulist\Components\Domain\Events
 * @subpackage Somnambulist\Components\Domain\Events\EventBus
 */
interface EventBus
{

    public function notify(AbstractEvent $event): void;
}
