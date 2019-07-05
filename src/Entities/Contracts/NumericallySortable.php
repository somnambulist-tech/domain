<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Contracts;

/**
 * Interface NumericallySortable
 *
 * @package    Somnambulist\Domain\Entities\Contracts
 * @subpackage Somnambulist\Domain\Entities\Contracts\NumericallySortable
 */
interface NumericallySortable
{

    public function ordinal(): int;

    public function changeSortOrderTo(int $ordinal): void;
}
