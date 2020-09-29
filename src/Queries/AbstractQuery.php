<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Queries;

/**
 * Class AbstractQuery
 *
 * @package    Somnambulist\Components\Domain\Queries
 * @subpackage Somnambulist\Components\Domain\Queries\AbstractQuery
 */
abstract class AbstractQuery
{

    public function __set($name, $value) {}

    public function __unset($name) {}
}
