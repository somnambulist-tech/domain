<?php declare(strict_types=1);

namespace Somnambulist\Domain\Commands;

/**
 * Interface CommandBus
 *
 * @package    Somnambulist\Domain\Commands
 * @subpackage Somnambulist\Domain\Commands\CommandBus
 */
interface CommandBus
{

    /**
     * Dispatch the command to the bus implementation
     *
     * @param AbstractCommand $command
     */
    public function dispatch(AbstractCommand $command): void;
}
