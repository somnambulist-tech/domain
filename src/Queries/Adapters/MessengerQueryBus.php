<?php declare(strict_types=1);

namespace Somnambulist\Components\Queries\Adapters;

use Somnambulist\Components\Queries\AbstractQuery;
use Somnambulist\Components\Queries\QueryBus;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

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
