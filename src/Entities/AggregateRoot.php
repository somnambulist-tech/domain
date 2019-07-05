<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities;

use Somnambulist\Domain\Entities\Contracts\AggregateRoot as AggregateRootContract;
use Somnambulist\Domain\Entities\Traits\Timestampable;
use Somnambulist\Domain\Events\Traits\RaisesDomainEvents;

/**
 * Class AggregateRoot
 *
 * @package    Somnambulist\Domain\Entities
 * @subpackage Somnambulist\Domain\Entities\AggregateRoot
 */
abstract class AggregateRoot implements AggregateRootContract
{

    use Timestampable;
    use RaisesDomainEvents;

}
