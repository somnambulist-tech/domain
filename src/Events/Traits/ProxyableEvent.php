<?php declare(strict_types=1);

namespace Somnambulist\Domain\Events\Traits;

use BadMethodCallException;
use Somnambulist\Domain\Events\AbstractDomainEvent;

/**
 * Trait ProxyableEvent
 *
 * Provides the base Domain event mapping methods to allow the domain events
 * to be used with other EventDispatchers that have a hard-typed event interface
 * e.g. Doctrine requires EventArgs instances, Symfony requires Event etc.
 *
 * @package    Somnambulist\Domain\Events\Traits
 * @subpackage Somnambulist\Domain\Events\Traits\ProxyableEvent
 */
trait ProxyableEvent
{

    /**
     * @var AbstractDomainEvent
     */
    private $event;

    /**
     * Constructor.
     *
     * @param AbstractDomainEvent $event
     */
    public function __construct(AbstractDomainEvent $event)
    {
        $this->event = $event;
    }

    public function proxiedEvent(): AbstractDomainEvent
    {
        return $this->event;
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this->event, $name)) {
            return $this->event->$name(...$arguments);
        }

        throw new BadMethodCallException(sprintf('Method "%s" does not exist on "%s"', $name, get_class($this->event)));
    }

    public static function createFrom(AbstractDomainEvent $event): self
    {
        return new static($event);
    }
}
