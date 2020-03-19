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

    abstract protected function getEntityName();

    abstract public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);

    abstract public function findOneBy(array $criteria, array $orderBy = null);

    public function findBySlug(string $slug): ?object
    {
        return $this->findOneBy(['slug' => $slug]);
    }

    public function findOrFailBySlug(string $slug): object
    {
        if (null === $entity = $this->findBySlug($slug)) {
            throw EntityNotFoundException::entityNotFound($this->getEntityName(), $slug);
        }

        return $entity;
    }
}
