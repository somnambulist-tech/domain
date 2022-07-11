<?php declare(strict_types=1);

namespace Somnambulist\Components\Jobs;

abstract class AbstractJob
{
    public function __set($name, $value) {}

    public function __unset($name) {}
}
