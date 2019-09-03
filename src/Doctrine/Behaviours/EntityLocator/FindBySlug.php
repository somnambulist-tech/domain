<?php declare(strict_types=1);

namespace Somnambulist\Domain\Doctrine\Behaviours\EntityLocator;

use Somnambulist\Domain\Entities\Exceptions\EntityNotFoundException;

/**
 * Trait FindBySlug
 *
 * @package    Somnambulist\Domain\Doctrine\Behaviours\EntityLocator
 * @subpackage Somnambulist\Domain\Doctrine\Behaviours\EntityLocator\FindBySlug
 */
trait FindBySlug
{

    /**
     * @return string
     */
    abstract protected function getEntityName();

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null|int   $limit
     * @param null|int   $offset
     *
     * @return mixed
     */
    abstract public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     *
     * @return null|object
     */
    abstract public function findOneBy(array $criteria, array $orderBy = null);

    /**
     * @param string $slug
     *
     * @return object|null
     */
    public function findBySlug(string $slug): ?object
    {
        return $this->findOneBy(['slug' => $slug]);
    }

    /**
     * @param string $slug
     *
     * @return object
     * @throws EntityNotFoundException
     */
    public function findOrFailBySlug(string $slug): object
    {
        if (null === $entity = $this->findBySlug($slug)) {
            throw EntityNotFoundException::entityNotFound($this->getEntityName(), $slug);
        }

        return $entity;
    }
}
