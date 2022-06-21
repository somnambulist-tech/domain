<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Support\Stubs\EventListeners;

use Somnambulist\Components\Events\AbstractEvent;
use Somnambulist\Components\Events\EventBus;
use function array_key_exists;

class AssertingEventBus implements EventBus
{

    private array $assertions;

    public function __construct(array $assertions)
    {
        $this->assertions = $assertions;
    }

    public function notify(AbstractEvent $event): void
    {
        $this->getAssertionFor($event)($event);
    }

    public function afterCurrent(AbstractEvent $event): void
    {
        $this->getAssertionFor($event)($event);
    }

    protected function getAssertionFor(AbstractEvent $event): callable
    {
        if (array_key_exists($event->name(), $this->assertions)) {
            return $this->assertions[$event->name()];
        }

        return function (AbstractEvent $event) {};
    }
}
