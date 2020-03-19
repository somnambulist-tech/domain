<?php declare(strict_types=1);

namespace Somnambulist\Domain\Jobs;

/**
 * Class AbstractJob
 *
 * @package    Somnambulist\Domain\Jobs
 * @subpackage Somnambulist\Domain\Jobs\AbstractJob
 */
abstract class AbstractJob
{

    public function __set($name, $value) {}

    public function __unset($name) {}
}
