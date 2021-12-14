<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Queries\Adapters;

use Somnambulist\Components\Domain\Queries\AbstractQuery;
use Somnambulist\Components\Domain\Queries\QueryBus;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class MessengerQueryBus
 *
 * @package    Somnambulist\Components\Domain\Queries\Adapters
 * @subpackage Somnambulist\Components\Domain\Queries\Adapters\MessengerQueryBus
 */
final class MessengerQueryBus implements QueryBus
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function execute(AbstractQuery $query): mixed
    {
        return $this->handle($query);
    }
}
