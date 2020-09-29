<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Commands;

/**
 * Class AbstractCommand
 *
 * @package    Somnambulist\Components\Domain\Commands
 * @subpackage Somnambulist\Components\Domain\Commands\AbstractCommand
 */
abstract class AbstractCommand
{

    public function __set($name, $value) {}

    public function __unset($name) {}
}
