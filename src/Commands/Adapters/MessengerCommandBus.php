<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Commands\Adapters;

use Somnambulist\Components\Domain\Commands\AbstractCommand;
use Somnambulist\Components\Domain\Commands\CommandBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

/**
 * Class MessengerCommandBus
 *
 * @package    Somnambulist\Components\Domain\Commands\Adapters
 * @subpackage Somnambulist\Components\Domain\Commands\Adapters\MessengerCommandBus
 */
final class MessengerCommandBus implements CommandBus
{
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function dispatch(AbstractCommand $command): void
    {
        $this->commandBus->dispatch($command);
    }

    public function afterCurrent(AbstractCommand $command): void
    {
        $this->commandBus->dispatch($command, [new DispatchAfterCurrentBusStamp()]);
    }
}
