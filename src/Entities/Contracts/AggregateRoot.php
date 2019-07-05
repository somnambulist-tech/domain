<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Contracts;

use Somnambulist\Domain\Events\Contracts\RaisesDomainEvents;

/**
 * Interface AggregateRoot
 *
 * @package    Somnambulist\Domain\Entities\Contracts
 * @subpackage Somnambulist\Domain\Entities\Contracts\AggregateRoot
 */
interface AggregateRoot extends Identifiable, Timestampable, RaisesDomainEvents
{

}
