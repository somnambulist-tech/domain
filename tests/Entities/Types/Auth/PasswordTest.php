<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Entities\Types\Auth;

use Assert\InvalidArgumentException;
use Somnambulist\Domain\Entities\Types\Auth\Password;
use PHPUnit\Framework\TestCase;
use function password_hash;
use const PASSWORD_DEFAULT;

/**
 * Class PasswordTest
 *
 * @package    Somnambulist\Domain\Tests\Entities\Types\Auth
 * @subpackage Somnambulist\Domain\Tests\Entities\Types\Auth\PasswordTest
 */
class PasswordTest extends TestCase
{

    /**
     * @group value-objects
     * @group value-objects-password
     */
    public function testCreate()
    {
        $pass = new Password($h = password_hash('password', PASSWORD_DEFAULT));

        $this->assertEquals($h, $pass->toString());
    }

    /**
     * @group value-objects
     * @group value-objects-password
     */
    public function testPasswordMustBeHashed()
    {
        $this->expectException(InvalidArgumentException::class);

        new Password('password');
    }
}
