<?php declare(strict_types=1);

namespace Somnambulist\Domain\Queries\Adapters;

use Somnambulist\Domain\Queries\AbstractQuery;
use Somnambulist\Domain\Queries\QueryBus;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class MessengerQueryBus
 *
 * @package    Somnambulist\Domain\Queries\Adapters
 * @subpackage Somnambulist\Domain\Queries\Adapters\MessengerQueryBus
 */
final class MessengerQueryBus implements QueryBus
{

    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function execute(AbstractQuery $query)
    {
        return $this->handle($query);
    }
}
