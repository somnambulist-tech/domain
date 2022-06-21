<?php declare(strict_types=1);

namespace Somnambulist\Components\Events;

use IlluminateAgnostic\Str\Support\Str;
use Somnambulist\Components\Collection\FrozenCollection;
use Somnambulist\Components\Models\Types\Identity\Aggregate;
use function array_merge;
use function class_exists;
use function explode;
use function is_a;
use function is_null;
use function microtime;
use function sprintf;
use function str_contains;
use function str_ends_with;
use function substr;
use function trigger_deprecation;

abstract class AbstractEvent
{
    protected string $group = 'app';
    protected ?string $name = null;

    private float $time;
    private string $type;

    public function __construct(private array $payload = [], private array $context = [], private ?Aggregate $aggregate = null)
    {
        $this->time = microtime(true);
        $this->type = static::class;
    }

    public function __set($name, $value)
    {
    }

    public function __unset($name)
    {
    }

    public function __toString(): string
    {
        return $this->name();
    }

    public static function create(array $payload = [], array $context = [], Aggregate $aggregate = null): static
    {
        return new static($payload, $context, $aggregate);
    }

    public function getAggregate(): ?Aggregate
    {
        trigger_deprecation('somnambulist/domain', '4.6.0', 'Use aggregate() instead');

        return $this->aggregate();
    }

    public function aggregate(): ?Aggregate
    {
        return $this->aggregate;
    }

    public function getGroup(): string
    {
        trigger_deprecation('somnambulist/domain', '4.6.0', 'Use group() instead');

        return $this->group();
    }

    public function group(): string
    {
        return $this->group;
    }

    public function getName(): string
    {
        trigger_deprecation('somnambulist/domain', '4.6.0', 'Use name() instead');

        return $this->name();
    }

    public function name(): string
    {
        if (is_null($this->name)) {
            $this->name = $this->parseName();
        }

        return $this->name;
    }

    public function getTime(): float
    {
        trigger_deprecation('somnambulist/domain', '4.6.0', 'Use createdAt() instead');

        return $this->createdAt();
    }

    public function createdAt(): float
    {
        return $this->time;
    }

    public function getType(): string
    {
        trigger_deprecation('somnambulist/domain', '4.6.0', 'Use type() instead');

        return $this->type();
    }

    public function type(): string
    {
        return $this->type;
    }

    public function getEventName(): string
    {
        trigger_deprecation('somnambulist/domain', '4.6.0', 'Use longName() instead');

        return $this->longName();
    }

    public function longName(): string
    {
        return sprintf('%s.%s', $this->group, Str::snake($this->name()));
    }

    private function parseName(): string
    {
        $a     = explode('\\', $this->type);
        $class = end($a);

        if (str_ends_with($class, "Event")) {
            $class = substr($class, 0, -5);
        }

        return $class;
    }

    public function payload(): FrozenCollection
    {
        return new FrozenCollection($this->payload);
    }

    public function context(): FrozenCollection
    {
        return new FrozenCollection($this->context);
    }

    public function appendContext(array $context): void
    {
        $this->context = array_merge($this->context, $context);
    }

    public function replaceContext(array $context): void
    {
        $this->context = $context;
    }

    /**
     * @param string $type
     * @param array  $array
     *
     * @return static
     * @internal
     */
    public static function fromArray(string $type, array $array): self
    {
        $class = class_exists($type) && is_a($type, self::class, true) ? $type : GenericEvent::class;

        $event        = new $class($array['payload'] ?? [], $array['context'] ?? []);
        $event->type  = $type;
        $event->time  = $array['event']['time'];
        $event->group = $array['event']['group'] ?? 'app';
        $event->name  = $array['event']['name'];

        if (str_contains($event->name, '.')) {
            $event->group = Str::beforeLast($event->name, '.');
            $event->name  = Str::afterLast($event->name, '.');
        }

        if ($array['aggregate']['class'] && $array['aggregate']['id']) {
            $event->aggregate = new Aggregate($array['aggregate']['class'], $array['aggregate']['id']);
        }

        return $event;
    }

    public function toArray(): array
    {
        return [
            'aggregate' => [
                'class' => $this->aggregate?->class(),
                'id'    => $this->aggregate?->identity(),
            ],
            'event'     => [
                'class' => $this->type,
                'group' => $this->group,
                'name'  => $this->name(),
                'time'  => $this->time,
            ],
            'payload'   => $this->payload,
            'context'   => $this->context,
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}

/**
 * @internal Only used for hydration of events in the fromArray() method
 * @noinspection
 */
final class GenericEvent extends AbstractEvent
{
}
