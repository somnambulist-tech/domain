<?php declare(strict_types=1);

namespace Somnambulist\Domain\Events;

use ReflectionClass;
use Somnambulist\Collection\Collection;
use Somnambulist\Collection\Immutable;
use Somnambulist\Domain\Entities\Contracts\AggregateRoot;
use Somnambulist\Domain\Entities\Types\Identity\Aggregate;
use Somnambulist\Domain\Events\Exceptions\InvalidPropertyException;

/**
 * Class DomainEvent
 *
 * Based on the Gist by B. Eberlei https://gist.github.com/beberlei/53cd6580d87b1f5cd9ca
 *
 * @package    Somnambulist\Domain\Events\Events
 * @subpackage Somnambulist\Domain\Events\Events\DomainEvent
 */
abstract class AbstractDomainEvent
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var Immutable
     */
    private $properties;

    /**
     * @var Immutable
     */
    private $context;

    /**
     * @var Aggregate
     */
    private $aggregate;

    /**
     * @var int
     */
    private $version;

    /**
     * @var float
     */
    private $time;

    /**
     * Constructor.
     *
     * @param array $payload Array of specific state change data
     * @param array $context Array of additional data providing context e.g. user, ip etc
     * @param int   $version A version identifier for the payload format
     */
    public function __construct(array $payload = [], array $context = [], int $version = 1)
    {
        $this->properties = new Immutable($payload);
        $this->context    = new Immutable($context);
        $this->time       = microtime(true);
        $this->version    = $version;
    }

    public function __toString()
    {
        return (string)$this->name();
    }

    public static function create(array $payload = [], array $context = [], int $version = 1)
    {
        $event = new static($payload, $context, $version);

        return $event;
    }

    public static function createFrom(Aggregate $aggregate, array $payload = [], array $context = [], int $version = 1)
    {
        $event = static::create($payload, $context, $version);
        $event->setAggregate($aggregate);

        return $event;
    }

    public static function createForAggregateRoot(AggregateRoot $aggregate, array $payload = [], array $context = [], int $version = 1)
    {
        $event = static::create($payload, $context, $version);
        $event->setAggregate(new Aggregate(get_class($aggregate), $aggregate->id()));

        return $event;
    }

    /**
     * Change the context of the event, returning a new event instance
     *
     * Context is merged with the current event context, all other details are preserved including the
     * original time of the event.
     *
     * @param array $context
     *
     * @return static
     */
    public function updateContext(array $context = [])
    {
        $event            = new static(
            $this->properties->toArray(),
            Collection::collect($this->context->toArray())->merge($context)->toArray(),
            $this->version
        );
        $event->time      = $this->time;
        $event->aggregate = $this->aggregate;

        return $event;
    }

    public function time(): float
    {
        return $this->time;
    }

    public function name(): string
    {
        if (is_null($this->name)) {
            $this->name = $this->parseName();
        }

        return $this->name;
    }

    private function parseName(): string
    {
        $class = (new ReflectionClass($this))->getShortName();

        if (substr($class, -5) === "Event") {
            $class = substr($class, 0, -5);
        }

        return $class;
    }

    public function properties(): Immutable
    {
        return $this->properties;
    }

    public function context(): Immutable
    {
        return $this->context;
    }

    public function version(): int
    {
        return $this->version;
    }

    public function aggregate(): ?Aggregate
    {
        return $this->aggregate;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function property(string $name)
    {
        if (!$this->properties->has($name)) {
            throw InvalidPropertyException::propertyDoesNotExist($name);
        }

        return $this->properties->get($name);
    }

    /**
     * Assign the aggregate class/id when they are available
     *
     * If the aggregate is using surrogate identifiers that are generated after a persistence
     * call, then the identity needs assigning to this event to claim ownership. This can only
     * happen once.
     *
     * @param Aggregate $aggregate
     */
    public function setAggregate(Aggregate $aggregate): void
    {
        if (is_null($this->aggregate)) {
            $this->aggregate = $aggregate;
        }
    }
}
