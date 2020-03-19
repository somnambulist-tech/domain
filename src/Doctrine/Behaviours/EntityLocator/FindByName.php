<?php declare(strict_types=1);

namespace Somnambulist\Domain\Doctrine\Behaviours\EntityLocator;

use Somnambulist\Collection\MutableCollection;

/**
 * Trait FindByName
 *
 * @package    Somnambulist\Domain\Doctrine\Behaviours\EntityLocator
 * @subpackage Somnambulist\Domain\Doctrine\Behaviours\EntityLocator\FindByName
 */
trait FindByName
{

    abstract public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);

    abstract public function findOneBy(array $criteria, array $orderBy = null);

    public function findByName(string $name): MutableCollection
    {
        return $this->findBy(['name' => $name], ['name' => 'ASC']);
    }

    public function findOneByName(string $name): ?object
    {
        return $this->findOneBy(['name' => $name]);
    }
}
