<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Entities\Types\Auth;

use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Domain\Entities\Types\Auth\Password;
use function password_hash;
use const PASSWORD_DEFAULT;

/**
 * Class PasswordTest
 *
 * @package    Somnambulist\Components\Domain\Tests\Entities\Types\Auth
 * @subpackage Somnambulist\Components\Domain\Tests\Entities\Types\Auth\PasswordTest
 *
 * @group entities
 * @group entities-types
 * @group entities-types-password
 */
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
