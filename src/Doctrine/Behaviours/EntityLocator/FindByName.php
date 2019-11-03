<?php declare(strict_types=1);

namespace Somnambulist\Domain\Doctrine\Behaviours\EntityLocator;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Trait FindByName
 *
 * @package    Somnambulist\Domain\Doctrine\Behaviours\EntityLocator
 * @subpackage Somnambulist\Domain\Doctrine\Behaviours\EntityLocator\FindByName
 */
trait FindByName
{

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
     * @param string $name
     *
     * @return ArrayCollection
     */
    public function findByName(string $name): ArrayCollection
    {
        return $this->findBy(['name' => $name], ['name' => 'ASC']);
    }

    /**
     * @param string $name
     *
     * @return null|object
     */
    public function findOneByName(string $name): ?object
    {
        return $this->findOneBy(['name' => $name]);
    }
}
