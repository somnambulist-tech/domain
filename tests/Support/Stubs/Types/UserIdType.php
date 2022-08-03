<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Support\Stubs\Types;

use Somnambulist\Components\Doctrine\Types\AbstractIdentityType;
use Somnambulist\Components\Tests\Support\Stubs\Models\UserId;

class UserIdType extends AbstractIdentityType
{

    protected string $name = 'user_id';
    protected string $class = UserId::class;
}
