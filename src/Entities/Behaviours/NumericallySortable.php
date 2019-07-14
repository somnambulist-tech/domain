<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Behaviours;

/**
 * Trait NumericallySortable
 *
 * @package    Somnambulist\Domain\Entities\Behaviours
 * @subpackage Somnambulist\Domain\Entities\Behaviours\NumericallySortable
 */
trait NumericallySortable
{

    private $ordinal = 0;

    public function ordinal(): int
    {
        return $this->ordinal;
    }

    public function changeSortOrderTo($ordinal): void
    {
        $this->ordinal = $ordinal;
    }
}
