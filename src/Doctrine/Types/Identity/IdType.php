<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Doctrine\Types\Identity;

use Somnambulist\Components\Domain\Doctrine\Types\AbstractIdentityType;
use Somnambulist\Components\Domain\Entities\Types\Identity\Id;

/**
 * Class IdType
 *
 * @package    Somnambulist\Components\Domain\Doctrine\Types
 * @subpackage Somnambulist\Components\Domain\Doctrine\Types\Identity\IdType
 */
class IdType extends AbstractIdentityType
{

    protected string $name = 'identity';
    protected string $class = Id::class;
}
