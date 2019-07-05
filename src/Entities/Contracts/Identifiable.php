<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Contracts;

/**
 * Interface Identifiable
 *
 * @package    Somnambulist\Domain\Entities\Contracts
 * @subpackage Somnambulist\Domain\Entities\Contracts\Identifiable
 */
interface Identifiable
{

    /**
     * @return mixed
     */
    public function id();
}
