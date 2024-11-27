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
use function Symfony\Component\String\u;

abstract class AbstractEvent
{
    protected string $group = 'app';
    protected ?string $name = null;

    private float $time;
    private string $type;

    public function __construct(
        private readonly array $payload = [],
        private readonly array $context = [],
        private readonly ?Aggregate $aggregate = null,
    ) {
        $this->time = microtime(true);
        $this->type = static::class;

        if (is_null($this->name)) {
            $this->name = $this->parseName();
        }
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

    public static function create(array $payload = [], array $context = [], ?Aggregate $aggregate = null): static
    {
        return new static($payload, $context, $aggregate);
    }

    public function aggregate(): ?Aggregate
    {
        return $this->aggregate;
    }

    public function group(): string
    {
        return $this->group;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function createdAt(): float
    {
        return $this->time;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function longName(): string
    {
        return sprintf('%s.%s', $this->group, $this->name());
    }

    private function parseName(): string
    {
        $a     = explode('\\', $this->type);
        $class = end($a);

        if (str_ends_with($class, "Event")) {
            $class = substr($class, 0, -5);
        }

        return u($class)->snake()->toString();
    }

    public function payload(): FrozenCollection
    {
        return new FrozenCollection($this->payload);
    }

    public function context(): FrozenCollection
    {
        return new FrozenCollection($this->context);
    }

    public function appendContext(array $context): static
    {
        $new = new static($this->payload, array_merge($this->context, $context), $this->aggregate);
        $new->time = $this->time;

        return $new;
    }

    public function replaceContext(array $context): static
    {
        $new = new static($this->payload, $context, $this->aggregate);
        $new->time = $this->time;

        return $new;
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
        $agg   = null;

        if ($array['aggregate']['class'] && $array['aggregate']['id']) {
            $agg = new Aggregate($array['aggregate']['class'], $array['aggregate']['id']);
        }

        $event        = new $class($array['payload'] ?? [], $array['context'] ?? [], $agg);
        $event->type  = $type;
        $event->time  = $array['event']['time'];
        $event->group = $array['event']['group'] ?? 'app';
        $event->name  = $array['event']['name'];

        if (str_contains($event->name, '.')) {
            $event->group = u($event->name)->beforeLast('.')->toString();
            $event->name  = u($event->name)->afterLast('.')->toString();
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
                'name'  => $this->name,
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
