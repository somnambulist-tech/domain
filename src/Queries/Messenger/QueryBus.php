<?php declare(strict_types=1);

namespace Somnambulist\Domain\Queries\Messenger;

use Somnambulist\Domain\Queries\AbstractQuery;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class QueryBus
 *
 * @package    Somnambulist\Domain\Queries\Messenger
 * @subpackage Somnambulist\Domain\Queries\Messenger\QueryBus
 */
final class QueryBus implements \Somnambulist\Domain\Queries\QueryBus
{

    use HandleTrait;

    /**
     * Constructor.
     *
     * @param MessageBusInterface $queryBus
     */
    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /**
     * @param AbstractQuery $query
     *
     * @return mixed
     */
    public function execute(AbstractQuery $query)
    {
        return $this->handle($query);
    }

    /**
     * @param AbstractQuery $query
     *
     * @return mixed
     */
    public function query(AbstractQuery $query)
    {
        return $this->execute($query);
    }
}
