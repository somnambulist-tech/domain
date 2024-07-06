<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Models\Types\Auth;

use Assert\InvalidArgumentException;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\Auth\Password;
use function password_hash;
use const PASSWORD_DEFAULT;

#[Group('models')]
#[Group('models-types')]
class PasswordTest extends TestCase
{
    public function testCreate()
    {
        $pass = new Password($h = password_hash('password', PASSWORD_DEFAULT));

        $this->assertEquals($h, $pass->toString());
    }

    public function testPasswordMustBeHashed()
    {
        $this->expectException(InvalidArgumentException::class);

        new Password('password');
    }
}
