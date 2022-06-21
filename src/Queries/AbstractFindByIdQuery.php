<?php declare(strict_types=1);

namespace Somnambulist\Components\Queries;

use Somnambulist\Components\Models\Types\Identity\AbstractIdentity;

abstract class AbstractFindByIdQuery extends AbstractQuery
{
    private AbstractIdentity $id;

    public function __construct(AbstractIdentity $id)
    {
        $this->id = $id;
    }

    public function __toString(): string
    {
        return (string)$this->id;
    }

    public function getId(): AbstractIdentity
    {
        trigger_deprecation('somnambulist/domain', '4.6.0', 'Use id() instead');

        return $this->id();
    }

    public function id(): AbstractIdentity
    {
        return $this->id;
    }
}
