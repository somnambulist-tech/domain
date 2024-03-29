<?php declare(strict_types=1);

namespace Somnambulist\Components\Commands;

interface CommandBus
{
    /**
     * Dispatch the command to the bus implementation
     *
     * @param AbstractCommand $command
     */
    public function dispatch(AbstractCommand $command): void;

    /**
     * Dispatch the command only after the current handler has finished without an exception
     *
     * @param AbstractCommand $command
     */
    public function afterCurrent(AbstractCommand $command): void;
}
