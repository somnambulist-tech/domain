<?php declare(strict_types=1);

namespace Somnambulist\Domain\Doctrine\Types\Identity;

use Somnambulist\Domain\Entities\Types\Identity\Id;

/**
 * Class IdType
 *
 * @package    Somnambulist\Domain\Doctrine\Types\Identity
 * @subpackage Somnambulist\Domain\Doctrine\Types\Identity\IdType
 */
class IdType extends AbstractIdentityType
{

    protected string $name = 'identity';
    protected string $class = Id::class;
}
