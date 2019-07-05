<?php declare(strict_types=1);

namespace Somnambulist\Domain\Events\Publishers\Laravel;

use Illuminate\Events\Dispatcher;
use Somnambulist\Domain\Events\AbstractEventPublisher;

/**
 * Class DomainEventPublisher
 *
 * @package    Somnambulist\Domain\Events\Publishers\Laravel
 * @subpackage Somnambulist\Domain\Events\Publishers\Laravel\DomainEventPublisher
 */
class DomainEventPublisher extends AbstractEventPublisher
{

    public function dispatch(): void
    {
        $events = $this->orderDomainEvents($this->gatherPublishedDomainEvents($this->entities()));

        $events->each(function ($event) {
            $this->dispatcher()->dispatch($event);
        });
    }

    /**
     * @return Dispatcher|object
     */
    private function dispatcher()
    {
        return $this->dispatcher;
    }
}
