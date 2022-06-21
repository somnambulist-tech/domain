<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Behaviours\EntityLocator;

use Somnambulist\Components\Collection\MutableCollection;

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
