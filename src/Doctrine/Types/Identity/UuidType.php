<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Types\Identity;

use Somnambulist\Components\Doctrine\Types\AbstractIdentityType;
use Somnambulist\Components\Models\Types\Identity\Uuid;

/**
 * Store Uuid instances as a type instead of as an embeddable, allows UUID
 * objects to be used as an id.
 *
 * Note: not recommended for use inside other value objects as an instance of UUID
 * will be hydrated instead of the string value.
 */
class UuidType extends AbstractIdentityType
{
    protected string $name  = 'uuid';
    protected string $class = Uuid::class;
}
