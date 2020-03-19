<?php declare(strict_types=1);

namespace Somnambulist\Domain\Commands\Adapters;

use Somnambulist\Domain\Commands\AbstractCommand;
use Somnambulist\Domain\Commands\CommandBus;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class MessengerCommandBus
 *
 * @package    Somnambulist\Domain\Commands\Adapters
 * @subpackage Somnambulist\Domain\Commands\Adapters\MessengerCommandBus
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
}
