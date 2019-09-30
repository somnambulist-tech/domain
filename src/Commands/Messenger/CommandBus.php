<?php declare(strict_types=1);

namespace Somnambulist\Domain\Commands\Messenger;

use Somnambulist\Domain\Commands\AbstractCommand;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class CommandBus
 *
 * @package    Somnambulist\Domain\Commands\Messenger
 * @subpackage Somnambulist\Domain\Commands\Messenger\CommandBus
 */
final class CommandBus implements \Somnambulist\Domain\Commands\CommandBus
{

    /**
     * @var MessageBusInterface
     */
    private $commandBus;

    /**
     * Constructor.
     *
     * @param MessageBusInterface $commandBus
     */
    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function dispatch(AbstractCommand $command): void
    {
        $this->commandBus->dispatch($command);
    }
}
