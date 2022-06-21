<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Behaviours\EntityLocator;

use Somnambulist\Components\Models\Exceptions\EntityNotFoundException;
use Somnambulist\Components\Models\Types\Identity\AbstractIdentity;

trait FindByUUID
{
    abstract protected function getEntityName();

    abstract public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);

    abstract public function findOneBy(array $criteria, array $orderBy = null);

    protected function getEntityUuidFieldName(): string
    {
        return 'uuid';
    }

    public function findByUUID(AbstractIdentity $uuid): ?object
    {
        return $this->findOneBy([$this->getEntityUuidFieldName() => (string)$uuid]);
    }

    public function findOrFailByUUID(AbstractIdentity $uuid): object
    {
        if (null === $entity = $this->findByUUID($uuid)) {
            throw EntityNotFoundException::entityNotFound($this->getEntityName(), (string)$uuid);
        }

        return $entity;
    }
}
