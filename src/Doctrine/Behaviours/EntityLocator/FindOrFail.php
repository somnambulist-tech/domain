<?php declare(strict_types=1);

namespace Somnambulist\Domain\Doctrine\Behaviours\EntityLocator;

use Somnambulist\Domain\Entities\Exceptions\EntityNotFoundException;

/**
 * Trait FindOrFail
 *
 * @package    Somnambulist\Domain\Doctrine\Behaviours\EntityLocator
 * @subpackage Somnambulist\Domain\Doctrine\Behaviours\EntityLocator\FindOrFail
 */
trait FindOrFail
{

    /**
     * @return string
     */
    abstract protected function getEntityName();

    /**
     * Finds an entity by its primary key / identifier.
     *
     * @param mixed    $id          The identifier.
     * @param int|null $lockMode    One of the \Doctrine\DBAL\LockMode::* constants
     *                              or NULL if no specific lock mode should be used
     *                              during the search.
     * @param int|null $lockVersion The lock version.
     *
     * @return object|null The entity instance or NULL if the entity can not be found.
     */
    abstract public function find($id, $lockMode = null, $lockVersion = null);

    /**
     * Finds a single entity by a set of criteria.
     *
     * @param array      $criteria
     * @param array|null $orderBy
     *
     * @return object|null The entity instance or NULL if the entity can not be found.
     */
    abstract public function findOneBy(array $criteria, array $orderBy = null);

    /**
     * @param string|int $id
     *
     * @return object
     * @throws EntityNotFoundException
     */
    public function findOrFail($id): object
    {
        if (null === $entity = $this->find($id)) {
            throw EntityNotFoundException::entityNotFound($this->getEntityName(), $id);
        }

        return $entity;
    }

    /**
     * Finds the first single entity matching the criteria or fails with Exception
     *
     * @param array $criteria Fields to limit selection by as key -> value pairs
     * @param array $orderBy  Fields to order by as field -> [ASC|DESC] pairs
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
