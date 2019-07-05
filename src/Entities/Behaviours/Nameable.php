<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Traits;

/**
 * Class Nameable
 *
 * @package    Somnambulist\Domain\Entities\Traits
 * @subpackage Somnambulist\Domain\Entities\Traits\Nameable
 */
trait Nameable
{

    /**
     * @var string
     */
    protected $name;

    public function name(): string
    {
        return $this->name;
    }
}
