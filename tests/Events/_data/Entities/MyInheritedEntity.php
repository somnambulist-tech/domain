<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Events\_data\Entities;

/**
 * Class MyInheritedEntity
 *
 * @package Somnambulist\Domain\Tests\Events\_data\Entities
 * @subpackage Somnambulist\Domain\Tests\Events\_data\Entities\MyInheritedEntity
 */
class MyInheritedEntity extends AbstractEntity
{

    private $id;

    /**
     * Constructor.
     *
     * @param $id
     * @param $name
     */
    public function __construct($id, $name)
    {
        $this->id = $id;

        parent::__construct($name);
    }
}
