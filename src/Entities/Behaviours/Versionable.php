<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Traits;

/**
 * Trait Versionable
 *
 * @package    Somnambulist\Domain\Entities\Traits
 * @subpackage Somnambulist\Domain\Entities\Traits\Versionable
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
