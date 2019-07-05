<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Contracts;

/**
 * Interface Activatable
 *
 * @package    Somnambulist\Domain\Entities\Contracts
 * @subpackage Somnambulist\Domain\Entities\Contracts\Activatable
 */
interface Activatable
{

    /**
     * Flag this entity as being active
     *
     * The implementation should raise a domain event to coincide with this
     *
     * @return void
     */
    public function activate(): void;

    /**
     * Flag this entity as being in-active
     *
     * The implementation should raise a domain event to coincide with this
     *
     * @return void
     */
    public function deactivate(): void;
}
