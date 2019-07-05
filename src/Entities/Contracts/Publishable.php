<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Contracts;

use Somnambulist\Domain\Entities\Types\DateTime\DateTime;

/**
 * Interface Publishable
 *
 * @package    Somnambulist\Domain\Entities\Contracts
 * @subpackage Somnambulist\Domain\Entities\Contracts\Publishable
 */
interface Publishable
{

    /**
     * Publish at the date/time supplied, or "now"
     *
     * The implementation should raise a domain event to coincide with this
     *
     * @param null|DateTime $date
     *
     * @return void
     */
    public function publishAt(DateTime $date = null): void;

    /**
     * Perform the necessary steps to un-publish the work
     *
     * The implementation should raise a domain event to coincide with this
     *
     * @return void
     */
    public function unpublish(): void;
}
