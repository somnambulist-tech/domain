<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Jobs;

/**
 * Class AbstractJob
 *
 * @package    Somnambulist\Components\Domain\Jobs
 * @subpackage Somnambulist\Components\Domain\Jobs\AbstractJob
 */
abstract class AbstractJob
{

    public function __set($name, $value) {}

    public function __unset($name) {}
}
