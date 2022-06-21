<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Types\Identity;

use Somnambulist\Components\Doctrine\Types\AbstractIdentityType;
use Somnambulist\Components\Models\Types\Identity\Id;

/**
 * Allows using an Id instance as a type instead of an embeddable, allowing it to be
 * used as an id type.
 */
class IdType extends AbstractIdentityType
{
    protected string $name = 'identity';
    protected string $class = Id::class;
}
