<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Events\_data\Entities;

/**
 * Class AbstractEntity
 *
 * @package Somnambulist\Domain\Tests\Events\_data\Entities
 * @subpackage Somnambulist\Domain\Tests\Events\_data\Entities\AbstractEntity
 */
abstract class AbstractEntity
{

    /**
     * @var string
     */
    private $name;

    /**
     * Constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
