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

    private Uuid $id;

    public function __construct(Uuid $id)
    {
        $this->id = $id;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }
}
