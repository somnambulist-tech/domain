<?php declare(strict_types=1);

namespace Somnambulist\Components\Queries\Adapters;

use RuntimeException;
use Somnambulist\Components\Queries\AbstractQuery;
use Somnambulist\Components\Queries\Contracts\UsesResponseClass;
use Somnambulist\Components\Queries\QueryBus;
use Somnambulist\Components\Queries\Responses\AbstractQueryResponse;
use Somnambulist\Components\Queries\Responses\QueryResponseStatus;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;
use function is_a;

final class MessengerQueryBus implements QueryBus
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /**
     * @param AbstractQuery $query
     *
     * @return mixed|AbstractQueryResponse
     */
    public function execute(AbstractQuery $query): mixed
    {
        if ($query instanceof UsesResponseClass) {
            return $this->executeWithResponse($query);
        }

        return $this->handle($query);
    }

    private function executeWithResponse(UsesResponseClass $query): AbstractQueryResponse
    {
        $e = null;

        try {
            $response = $this->handle($query);
        } catch (Throwable $e) {
            $response = null;
        }

        $type = $query->responseClass();

        if (!is_a($type, AbstractQueryResponse::class, true)) {
            throw new RuntimeException(
                sprintf(
                    'Query "%s" defined a response class of "%s" but this is not an instance of "%s"',
                    $query::class,
                    $query->responseClass(),
                    AbstractQueryResponse::class,
                )
            );
        }

        return new $type($response, new QueryResponseStatus($e));
    }
}
