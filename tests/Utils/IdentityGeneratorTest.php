<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Utils;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\Identity\Uuid;
use Somnambulist\Components\Tests\Support\Stubs\Models\UserId;
use Somnambulist\Components\Utils\IdentityGenerator;

/**
 * @group utils
 * @group utils-identity-generator
 */
class IdentityGeneratorTest extends TestCase
{
    public function testRandom()
    {
        $uuid = IdentityGenerator::random();

        $this->assertInstanceOf(Uuid::class, $uuid);
    }

    public function testRandomOfType()
    {
        $uuid = IdentityGenerator::randomOfType(UserId::class);

        $this->assertInstanceOf(UserId::class, $uuid);
    }

    public function testHashed()
    {
        $ns = new Uuid('e9dd9eee-435e-453d-8437-2919f4105a32');

        $uuid1 = IdentityGenerator::hashed($ns, 'my', 'hashed', 'uuid');
        $uuid2 = IdentityGenerator::hashed($ns, 'my.hashed.uuid');

        $this->assertTrue($uuid1->equals($uuid2));
    }

    public function testHashedOfType()
    {
        $ns = new Uuid('e9dd9eee-435e-453d-8437-2919f4105a32');

        $uuid1 = IdentityGenerator::hashedOfType($ns, UserId::class, 'my', 'hashed', 'uuid');
        $uuid2 = IdentityGenerator::hashedOfType($ns, UserId::class, 'my.hashed.uuid');

        $this->assertInstanceOf(UserId::class, $uuid1);
        $this->assertInstanceOf(UserId::class, $uuid2);

        $this->assertTrue($uuid1->equals($uuid2));
    }
}
