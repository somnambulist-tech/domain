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

    public function __set($name, $value) {}

    public function __unset($name) {}
}
