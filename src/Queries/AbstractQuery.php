<?php declare(strict_types=1);

namespace Somnambulist\Domain\Queries;

/**
 * Class AbstractQuery
 *
 * @package    Somnambulist\Domain\Queries
 * @subpackage Somnambulist\Domain\Queries\AbstractQuery
 */
abstract class AbstractQuery
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
