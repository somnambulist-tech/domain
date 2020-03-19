<?php declare(strict_types=1);

namespace Somnambulist\Domain\Doctrine;

use Doctrine\ORM\EntityRepository;
use Somnambulist\Collection\MutableCollection;
use Somnambulist\Domain\Doctrine\Behaviours\EntityLocator\FindByUUID;
use Somnambulist\Domain\Doctrine\Behaviours\EntityLocator\FindOrFail;
use Somnambulist\Domain\Doctrine\Behaviours\EntityLocator\Paginate;

/**
 * Class AbstractEntityLocator
 *
 * Extends the standard Doctrine EntityRepository to a Locator while adding wrappers
 * to return ArrayCollection's and assorted helper methods for loading entities.
 *
 * @package    Somnambulist\Domain\Doctrine
 * @subpackage Somnambulist\Domain\Doctrine\AbstractEntityLocator
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
    public function findAll()
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
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return new MutableCollection(parent::findBy($criteria, $orderBy, $limit, $offset));
    }
}
