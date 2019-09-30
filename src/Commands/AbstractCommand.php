<?php declare(strict_types=1);

namespace Somnambulist\Domain\Commands;

/**
 * Class AbstractCommand
 *
 * @package    Somnambulist\Domain\Commands
 * @subpackage Somnambulist\Domain\Commands\AbstractCommand
 */
abstract class AbstractCommand
{

    public function __set($name, $value)
    {
        // prevent arbitrary properties
    }

    public function __unset($name)
    {
        // prevent arbitrary properties
    }
}
