<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Entities;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Domain\Entities\Types\Auth\Password;
use Somnambulist\Components\Domain\Entities\Types\Identity\EmailAddress;
use Somnambulist\Components\Domain\Tests\Support\Stubs\Events\UserCreated;
use Somnambulist\Components\Domain\Tests\Support\Stubs\Events\UserRegistrationComplete;
use Somnambulist\Components\Domain\Tests\Support\Stubs\Models\Name;
use Somnambulist\Components\Domain\Tests\Support\Stubs\Models\User;
use Somnambulist\Components\Domain\Tests\Support\Stubs\Models\UserId;
use Somnambulist\Components\Domain\Utils\IdentityGenerator;
use Somnambulist\Components\Domain\Utils\Tests\Assertions\AssertHasDomainEventOfType;
use function password_hash;
use const PASSWORD_DEFAULT;

/**
 * Class AggregateRootTest
 *
 * @package    Somnambulist\Components\Domain\Tests\Entities
 * @subpackage Somnambulist\Components\Domain\Tests\Entities\AggregateRootTest
 *
 * @group entities
 * @group entities-aggregate
 */
class AggregateRootTest extends TestCase
{

    use AssertHasDomainEventOfType;

    public function testAssigningIdentity()
    {
        $user = User::create(
            $id = IdentityGenerator::randomOfType(UserId::class),
            new Name('bob'),
            new EmailAddress('bob@example.com'),
            new Password(password_hash('password', PASSWORD_DEFAULT))
        );

        $this->assertSame($id, $user->id());
        $this->assertHasDomainEventOfType($user, UserCreated::class);
    }

    public function testRaisingEvents()
    {
        $user = User::create(
            $id = IdentityGenerator::randomOfType(UserId::class),
            new Name('bob'),
            new EmailAddress('bob@example.com'),
            new Password(password_hash('password', PASSWORD_DEFAULT))
        );
        $user->completeRegistration();

        $events = $user->releaseAndResetEvents();

        $this->assertInstanceOf(UserCreated::class, $events[0]);
        $this->assertInstanceOf(UserRegistrationComplete::class, $events[1]);
    }

    public function testRaisingEventsSetsAggregateRoot()
    {
        $user = User::create(
            $id = IdentityGenerator::randomOfType(UserId::class),
            new Name('bob'),
            new EmailAddress('bob@example.com'),
            new Password(password_hash('password', PASSWORD_DEFAULT))
        );

        $event = $user->releaseAndResetEvents()[0];

        $this->assertNotNull($event->aggregate());
        $this->assertEquals(User::class, $event->aggregate()->class());
        $this->assertEquals((string)$id, $event->aggregate()->identity());
    }

    public function testEqualityIsByIdentity()
    {
        $user = User::create(
            $id = IdentityGenerator::randomOfType(UserId::class),
            new Name('bob'),
            new EmailAddress('bob@example.com'),
            new Password(password_hash('password', PASSWORD_DEFAULT))
        );
        $user2 = User::create(
            IdentityGenerator::randomOfType(UserId::class),
            new Name('bob'),
            new EmailAddress('bob@example.com'),
            new Password(password_hash('password', PASSWORD_DEFAULT))
        );
        $user3 = User::create(
            $id,
            new Name('bob'),
            new EmailAddress('bob@example.com'),
            new Password(password_hash('password', PASSWORD_DEFAULT))
        );

        $this->assertFalse($user->equals($user2));
        $this->assertTrue($user->equals($user3));
    }
}
