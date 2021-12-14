<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Queries;

use Somnambulist\Components\Domain\Entities\Types\Identity\Uuid;

/**
 * Class AbstractFindByIdQuery
 *
 * @package Somnambulist\Components\Domain\Queries
 * @subpackage Somnambulist\Components\Domain\Queries\AbstractFindByIdQuery
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
