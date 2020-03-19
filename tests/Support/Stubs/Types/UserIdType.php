<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Support\Stubs\Types;

use Somnambulist\Domain\Doctrine\Types\Identity\AbstractIdentityType;
use Somnambulist\Domain\Tests\Support\Stubs\Models\UserId;

/**
 * Class UserIdType
 *
 * @package    Somnambulist\Domain\Tests\Support\Stubs\Types
 * @subpackage Somnambulist\Domain\Tests\Support\Stubs\Types\UserIdType
 */
class UserIdType extends AbstractIdentityType
{

    protected string $name = 'user_id';
    protected string $class = UserId::class;
}
