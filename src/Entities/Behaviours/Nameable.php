<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Behaviours;

/**
 * Class Nameable
 *
 * @package    Somnambulist\Domain\Entities\Behaviours
 * @subpackage Somnambulist\Domain\Entities\Behaviours\Nameable
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
