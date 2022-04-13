<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Queries;

use Somnambulist\Components\Domain\Entities\Types\Identity\Uuid;

/**
 * Class AbstractFindByIdQuery
 *
 * @package    Somnambulist\Components\Domain\Queries
 * @subpackage Somnambulist\Components\Domain\Queries\AbstractFindByIdQuery
 */
abstract class AbstractFindByIdQuery extends AbstractQuery
{
    private Uuid $id;

    public function __construct(Uuid $id)
    {
        $this->id = $id;
    }

    public function __toString(): string
    {
        return (string)$this->id;
    }

    public function getId(): Uuid
    {
        trigger_deprecation('somnambulist/domain', '4.6.0', 'Use id() instead');

        return $this->id();
    }

    public function id(): Uuid
    {
        return $this->id;
    }
}
