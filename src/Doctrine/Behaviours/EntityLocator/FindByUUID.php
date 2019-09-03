<?php declare(strict_types=1);

namespace Somnambulist\Domain\Doctrine\Behaviours\EntityLocator;

use Somnambulist\Domain\Entities\Exceptions\EntityNotFoundException;
use Somnambulist\Domain\Entities\Types\Identity\Uuid;

/**
 * Trait FindByUUID
 *
 * @package    Somnambulist\Domain\Doctrine\Behaviours\EntityLocator
 * @subpackage Somnambulist\Domain\Doctrine\Behaviours\EntityLocator\FindByUUID
 */
trait FindByUUID
{

    /**
     * @return string
     */
    abstract protected function getEntityName();

    /**
     * Returns the string value of the UUID field name.
     *
     * If UUID is mapped as a type, this will be `uuid`; however if the UUID is defined as an
     * embedded object, this would be `uuid.value`. It should be overridden as necessary
     * depending on the implementation.
     *
     * @return string
     */
    abstract protected function getEntityUuidFieldName(): string;

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
     * @param string|Uuid $uuid
     *
     * @return null|object
     */
    public function findByUUID($uuid): ?object
    {
        return $this->findOneBy([$this->getEntityUuidFieldName() => (string)$uuid]);
    }

    /**
     * @param string|Uuid $uuid
     *
     * @return null|object
     * @throws EntityNotFoundException
     */
    public function findOrFailByUUID($uuid): object
    {
        if (null === $entity = $this->findByUUID($uuid)) {
            throw EntityNotFoundException::entityNotFound($this->getEntityName(), $uuid);
        }

        return $entity;
    }
}
