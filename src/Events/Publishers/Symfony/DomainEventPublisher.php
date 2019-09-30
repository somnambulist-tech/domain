<?php declare(strict_types=1);

namespace Somnambulist\Domain\Events\Publishers\Symfony;

use Somnambulist\Domain\Events\AbstractEventPublisher;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class DomainEventPublisher
 *
 * @package    Somnambulist\Domain\Events\Publishers\Symfony
 * @subpackage Somnambulist\Domain\Events\Publishers\Symfony\DomainEventPublisher
 */
class DomainEventPublisher extends AbstractEventPublisher
{

    public function dispatch(): void
    {
        $events = $this->orderDomainEvents($this->gatherPublishedDomainEvents($this->entities()));

        $events->each(function ($event) {
            $proxy = EventProxy::createFrom($event);

            $this->dispatcher()->dispatch($proxy, $proxy->name());
        });
    }

    /**
     * @return EventDispatcher|object
     */
    private function dispatcher()
    {
        return $this->dispatcher;
    }
}
