<?php declare(strict_types=1);

namespace Somnambulist\Domain\Events;

use IlluminateAgnostic\Str\Support\Str;
use InvalidArgumentException;
use ReflectionClass;
use Somnambulist\Collection\FrozenCollection as Immutable;
use Somnambulist\Collection\MutableCollection as Collection;
use Somnambulist\Domain\Entities\Contracts\AggregateRoot;
use Somnambulist\Domain\Entities\Types\Identity\Aggregate;
use Somnambulist\Domain\Events\Exceptions\InvalidPropertyException;
use function array_pop;
use function class_exists;
use function explode;
use function get_class;
use function implode;
use function is_a;
use function is_null;
use function last;
use function microtime;
use function sprintf;
use function strpos;
use function strrpos;
use function substr;

/**
 * Class DomainEvent
 *
 * Based on the Gist by B. Eberlei https://gist.github.com/beberlei/53cd6580d87b1f5cd9ca
 *
 * @package    Somnambulist\Domain\Events\Events
 * @subpackage Somnambulist\Domain\Events\Events\DomainEvent
 *
 * @property string $group Define to set the group name for the event
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
     * @var string
     */
    private $type;

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
        $this->type       = static::class;
    }

    public function __set($name, $value)
    {
        // prevent arbitrary properties
    }

    public function __unset($name)
    {
        // prevent arbitrary properties
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

    /**
     * Returns a suitable routing key for broadcasting this event in `group.event_name` format
     *
     * @return string
     */
    public function notificationName(): string
    {
        return sprintf('%s.%s', $this->notificationGroup(), Str::snake($this->name()));
    }

    private function notificationGroup(): string
    {
        return (isset($this->group) ? $this->group : (defined(static::class . '::NOTIFICATION_GROUP') ? static::NOTIFICATION_GROUP : 'app'));
    }

    private function parseName(): string
    {
        $a     = explode('\\', $this->type);
        $class = end($a);

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

    public function type(): string
    {
        return $this->type;
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

    /**
     * @param string $type
     * @param array  $array
     *
     * @return static
     * @internal
     */
    public static function fromArray(string $type, array $array = []): self
    {
        if (class_exists($type)) {
            if (!is_a($type, AbstractDomainEvent::class, $allowString = true)) {
                throw new InvalidArgumentException(sprintf('Type "%s" is not a "%s" class', $type, self::class));
            }

            $event = new $type($array['payload'] ?? [], $array['context'] ?? [], $array['event']['version'] ?? 1);
        } else {
            $event = new class($array['payload'] ?? [], $array['context'] ?? [], $array['event']['version'] ?? 1) extends AbstractDomainEvent
            {
                protected $group;
            };
            $event->type = $type;

            if (false !== strpos($array['event']['name'], '.')) {
                $pieces = explode('.', $array['event']['name']);
                array_pop($pieces);

                $event->group = implode('.', $pieces);
            }
        }

        /** @var AbstractDomainEvent $event */
        $event->time = $array['event']['time'];

        if ($array['aggregate']['class'] && $array['aggregate']['id']) {
            $event->aggregate = new Aggregate($array['aggregate']['class'], $array['aggregate']['id']);
        }

        return $event;
    }

    public function toArray(): array
    {
        return [
            'aggregate' => [
                'class' => $this->aggregate ? $this->aggregate()->class() : null,
                'id'    => $this->aggregate ? $this->aggregate()->identity() : null,
            ],
            'event'     => [
                'class'   => static::class,
                'name'    => $this->notificationName(),
                'version' => $this->version(),
                'time'    => $this->time(),
            ],
            'context'   => $this->context()->toArray(),
            'payload'   => $this->properties()->toArray(),
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
