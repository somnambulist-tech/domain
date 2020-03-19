<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Utils;

use Somnambulist\Domain\Entities\Types\Identity\Uuid;
use Somnambulist\Domain\Tests\Support\Stubs\Models\UserId;
use Somnambulist\Domain\Utils\IdentityGenerator;
use PHPUnit\Framework\TestCase;

/**
 * Class IdentityGeneratorTest
 *
 * @package Somnambulist\Domain\Tests\Utils
 * @subpackage Somnambulist\Domain\Tests\Utils\IdentityGeneratorTest
 *
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
