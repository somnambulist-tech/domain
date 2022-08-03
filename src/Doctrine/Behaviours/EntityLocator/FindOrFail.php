<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Behaviours\EntityLocator;

use Somnambulist\Components\Models\Exceptions\EntityNotFoundException;

trait FindOrFail
{
    abstract protected function getEntityName();

    abstract public function find($id, $lockMode = null, $lockVersion = null);

    abstract public function findOneBy(array $criteria, array $orderBy = null);

    /**
     * @param mixed    $id
     * @param int|null $lockMode
     * @param int|null $lockVersion
     *
     * @return object
     * @throws EntityNotFoundException
     */
    public function findOrFail(mixed $id, $lockMode = null, $lockVersion = null): object
    {
        if (null === $entity = $this->find((string)$id, $lockMode, $lockVersion)) {
            throw EntityNotFoundException::entityNotFound($this->getEntityName(), (string)$id);
        }

        return $entity;
    }

    /**
     * Finds the first single entity matching the criteria or fails with Exception
     *
     * @param array      $criteria Fields to limit selection by as key -> value pairs
     * @param array|null $orderBy  Fields to order by as field -> [ASC|DESC] pairs
     *
     * @return object
     * @throws EntityNotFoundException
     */
    public function findOneByOrFail(array $criteria, array $orderBy = null): object
    {
        if (null === $entity = $this->findOneBy($criteria, $orderBy)) {
            throw EntityNotFoundException::entityNotFound($this->getEntityName(), ...array_values($criteria));
        }

        return $entity;
    }
}
