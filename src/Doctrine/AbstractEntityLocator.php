<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Doctrine;

use Doctrine\ORM\EntityRepository;
use Somnambulist\Components\Collection\MutableCollection;
use Somnambulist\Components\Domain\Doctrine\Behaviours\EntityLocator\FindByUUID;
use Somnambulist\Components\Domain\Doctrine\Behaviours\EntityLocator\FindOrFail;
use Somnambulist\Components\Domain\Doctrine\Behaviours\EntityLocator\Paginate;

/**
 * Class AbstractEntityLocator
 *
 * Extends the standard Doctrine EntityRepository to a Locator while adding wrappers
 * to return ArrayCollection's and assorted helper methods for loading entities.
 *
 * @package    Somnambulist\Components\Domain\Doctrine
 * @subpackage Somnambulist\Components\Domain\Doctrine\AbstractEntityLocator
 */
abstract class AbstractEntityLocator extends EntityRepository
{
    use FindOrFail;
    use FindByUUID;
    use Paginate;

    /**
     * Finds all entities in the repository.
     *
     * @return MutableCollection|object[]
     */
    public function findAll(): MutableCollection
    {
        return $this->findBy([]);
    }

    /**
     * Finds entities by a set of criteria.
     *
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return MutableCollection|object[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): MutableCollection
    {
        return new MutableCollection(parent::findBy($criteria, $orderBy, $limit, $offset));
    }
}
