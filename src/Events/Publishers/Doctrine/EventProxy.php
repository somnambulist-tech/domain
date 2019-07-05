<?php declare(strict_types=1);

namespace Somnambulist\Domain\Events\Publishers\Doctrine;

use Doctrine\Common\EventArgs;
use Somnambulist\Collection\Immutable;
use Somnambulist\Domain\Events\Traits\ProxyableEvent;

/**
 * Class EventProxy
 *
 * @package    Somnambulist\Domain\Events\Publishers\Doctrine
 * @subpackage Somnambulist\Domain\Events\Publishers\Doctrine\EventProxy
 *
 * @method string name()
 * @method Immutable context()
 * @method Immutable payload()
 * @method Immutable properties()
 * @method mixed property(string $name)
 * @method float time()
 * @method int version()
 */
class EventProxy extends EventArgs
{

    use ProxyableEvent;

}
