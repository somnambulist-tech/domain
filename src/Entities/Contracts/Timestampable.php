<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Contracts;

/**
 * Interface Timestampable
 *
 * @package    Somnambulist\Domain\Entities\Contracts
 * @subpackage Somnambulist\Domain\Entities\Contracts\Timestampable
 */
interface Timestampable
{

    public function initializeTimestamps(): void;

    public function updateTimestamps(): void;
}
