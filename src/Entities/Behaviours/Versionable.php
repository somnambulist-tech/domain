<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Behaviours;

/**
 * Trait Versionable
 *
 * @package    Somnambulist\Domain\Entities\Behaviours
 * @subpackage Somnambulist\Domain\Entities\Behaviours\Versionable
 */
trait Versionable
{

    protected $version = 0;

    public function version(): int
    {
        return $this->version;
    }

    public function incrementVersion(): void
    {
        ++$this->version;
    }
}
