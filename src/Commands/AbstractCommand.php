<?php declare(strict_types=1);

namespace Somnambulist\Components\Commands;

abstract class AbstractCommand
{
    public function __set($name, $value) {}

    public function __unset($name) {}
}
