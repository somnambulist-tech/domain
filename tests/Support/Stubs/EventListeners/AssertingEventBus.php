<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Support\Stubs\EventListeners;

use Somnambulist\Components\Domain\Events\AbstractEvent;
use Somnambulist\Components\Domain\Events\EventBus;
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
        if (array_key_exists($event->getName(), $this->assertions)) {
            return $this->assertions[$event->getName()];
        }

        return function (AbstractEvent $event) {};
    }
}
