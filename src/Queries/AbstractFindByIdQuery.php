<?php declare(strict_types=1);

namespace Somnambulist\Domain\Queries;

use Somnambulist\Domain\Entities\Types\Identity\Uuid;

/**
 * Class AbstractFindByIdQuery
 *
 * @package Somnambulist\Domain\Queries
 * @subpackage Somnambulist\Domain\Queries\AbstractFindByIdQuery
 */
abstract class AbstractFindByIdQuery extends AbstractQuery
{

    /**
     * @var Uuid
     */
    private $id;

    /**
     * Constructor.
     *
     * @param Uuid $id
     */
    public function __construct(Uuid $id)
    {
        $this->id = $id;
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }
}
