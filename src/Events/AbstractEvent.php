<?php declare(strict_types=1);

namespace Somnambulist\Domain\Events;

use IlluminateAgnostic\Str\Support\Str;
use Somnambulist\Collection\FrozenCollection;
use Somnambulist\Domain\Entities\Types\Identity\Aggregate;
use function array_merge;
use function explode;
use function is_null;
use function microtime;
use function sprintf;
use function strpos;
use function substr;

/**
 * Class AbstractEvent
 *
 * @package    Somnambulist\Domain\Events
 * @subpackage Somnambulist\Domain\Events\AbstractEvent
 */
abstract class AbstractEvent
{

    protected string $group = 'app';
    protected ?string $name = null;

    private ?Aggregate $aggregate;
    private array $payload;
    private array $context;
    private float $time;
    private string $type;

    public function __construct(array $payload = [], array $context = [], Aggregate $aggregate = null)
    {
        $this->aggregate = $aggregate;
        $this->payload   = $payload;
        $this->context   = $context;
        $this->time      = microtime(true);
        $this->type      = static::class;
    }

    public function __set($name, $value) {}

    public function __unset($name) {}

    public function __toString()
    {
        return (string)$this->getName();
    }

    public static function create(array $payload = [], array $context = [], Aggregate $aggregate = null)
    {
        return new static($payload, $context, $aggregate);
    }

    public function getAggregate(): ?Aggregate
    {
        return $this->aggregate;
    }

    public function getGroup(): string
    {
        return $this->group;
    }

    public function getName(): string
    {
        if (is_null($this->name)) {
            $this->name = $this->parseName();
        }

        return $this->name;
    }

    public function getTime(): float
    {
        return $this->time;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getEventName(): string
    {
        return sprintf('%s.%s', $this->group, Str::snake($this->getName()));
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
        $event        = new class($array['payload'] ?? [], $array['context'] ?? []) extends AbstractEvent {};
        $event->type  = $type;
        $event->time  = $array['event']['time'];
        $event->group = $array['event']['group'] ?? 'app';
        $event->name  = $array['event']['name'];

        if (false !== strpos($event->name, '.')) {
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
                'class' => $this->aggregate ? $this->aggregate->class() : null,
                'id'    => $this->aggregate ? $this->aggregate->identity() : null,
            ],
            'event'     => [
                'class' => $this->type,
                'group' => $this->group,
                'name'  => $this->getName(),
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
