<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Contracts;

/**
 * Interface Versionable
 *
 * @package    Somnambulist\Domain\Entities\Contracts
 * @subpackage Somnambulist\Domain\Entities\Contracts\Versionable
 */
interface Versionable
{

    public function version(): int;

    /**
     * Increase the version scheme of the entity
     *
     * @return void
     */
    public function incrementVersion(): void;
}
