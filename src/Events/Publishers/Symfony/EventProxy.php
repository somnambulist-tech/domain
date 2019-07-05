<?php declare(strict_types=1);

namespace Somnambulist\Domain\Events\Publishers\Symfony;

use Somnambulist\Collection\Immutable;
use Somnambulist\Domain\Events\Traits\ProxyableEvent;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class EventProxy
 *
 * @package    Somnambulist\Domain\Events\Publishers\Symfony
 * @subpackage Somnambulist\Domain\Events\Publishers\Symfony\EventProxy
 *
 * @method Immutable context()
 * @method Immutable payload()
 * @method Immutable properties()
 * @method mixed property(string $name)
 * @method float time()
 * @method int version()
 */
class EventProxy extends Event
{

    use ProxyableEvent;

    /**
     * Returns a Symfony style dot separated name e.g.: OrderPlacedEvent -> order.placed
     *
     * @return string
     */
    public function name()
    {
        $value = $this->event->name();

        $value = preg_replace('/\s+/u', '', $value);
        $value = strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1.', $value));

        return $value;
    }
}
