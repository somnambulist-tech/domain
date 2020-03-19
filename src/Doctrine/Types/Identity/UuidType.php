<?php declare(strict_types=1);

namespace Somnambulist\Domain\Doctrine\Types\Identity;

use Somnambulist\Domain\Entities\Types\Identity\Uuid;

/**
 * Class UuidType
 *
 * UUID fields will be stored as a string in the database and converted back to
 * the Uuid value object when querying.
 *
 * @package    Somnambulist\Domain\Doctrine\Types
 * @subpackage Somnambulist\Domain\Doctrine\Types\Identity\UuidType
 */
class UuidType extends AbstractIdentityType
{

    protected string $name = 'uuid';
    protected string $class = Uuid::class;

}
