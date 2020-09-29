<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Doctrine\Types\Identity;

use Somnambulist\Components\Domain\Entities\Types\Identity\Uuid;

/**
 * Class UuidType
 *
 * UUID fields will be stored as a string in the database and converted back to
 * the Uuid value object when querying.
 *
 * @package    Somnambulist\Components\Domain\Doctrine\Types
 * @subpackage Somnambulist\Components\Domain\Doctrine\Types\Identity\UuidType
 */
class UuidType extends AbstractIdentityType
{

    protected string $name = 'uuid';
    protected string $class = Uuid::class;

}
