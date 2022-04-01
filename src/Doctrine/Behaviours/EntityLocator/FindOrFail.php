<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Doctrine\Behaviours\EntityLocator;

use Somnambulist\Components\Domain\Entities\Exceptions\EntityNotFoundException;

/**
 * Trait FindOrFail
 *
 * @package    Somnambulist\Components\Domain\Doctrine\Behaviours\EntityLocator
 * @subpackage Somnambulist\Components\Domain\Doctrine\Behaviours\EntityLocator\FindOrFail
 */
trait FindOrFail
{
    abstract protected function getEntityName();

    abstract public function find($id, $lockMode = null, $lockVersion = null);

    abstract public function findOneBy(array $criteria, array $orderBy = null);

    /**
     * @param string|int $id
     *
     * @return object
     * @throws EntityNotFoundException
     */
    public function findOrFail($id): object
    {
        if (null === $entity = $this->find((string)$id)) {
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
            throw EntityNotFoundException::entityNotFound($this->getEntityName(), implode(':', $criteria));
        }

        return $entity;
    }
}
