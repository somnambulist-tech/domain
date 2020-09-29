<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Support\Stubs\Types;

use Somnambulist\Components\Domain\Doctrine\Types\Identity\AbstractIdentityType;
use Somnambulist\Components\Domain\Tests\Support\Stubs\Models\UserId;

/**
 * Class UserIdType
 *
 * @package    Somnambulist\Components\Domain\Tests\Support\Stubs\Types
 * @subpackage Somnambulist\Components\Domain\Tests\Support\Stubs\Types\UserIdType
 */
class UserIdType extends AbstractIdentityType
{

    protected string $name = 'user_id';
    protected string $class = UserId::class;
}
