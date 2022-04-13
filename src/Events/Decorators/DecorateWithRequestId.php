<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Events\Decorators;

use Somnambulist\Components\Domain\Events\AbstractEvent;
use Somnambulist\Components\Domain\Events\EventDecoratorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class DecorateWithRequestId
 *
 * @package    Somnambulist\Components\Domain\Events\Decorators
 * @subpackage Somnambulist\Components\Domain\Events\Decorators\DecorateWithRequestId
 */
class DecorateWithRequestId implements EventDecoratorInterface
{
    private string $header = 'X-Request-Id';

    public function __construct(private RequestStack $requestStack, string $header = null)
    {
        if (!is_null($header)) {
            $this->header = $header;
        }
    }

    public function decorate(AbstractEvent $event): AbstractEvent
    {
        $request = $this->requestStack->getCurrentRequest();

        $event->appendContext(['request_id' => $request->headers->get($this->header)]);

        return $event;
    }
}
