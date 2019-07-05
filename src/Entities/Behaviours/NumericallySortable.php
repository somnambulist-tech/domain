<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Traits;

/**
 * Trait NumericallySortable
 *
 * @package    Somnambulist\Domain\Entities\Traits
 * @subpackage Somnambulist\Domain\Entities\Traits\NumericallySortable
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
