<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Utils;

use Somnambulist\Domain\Entities\Types\Identity\Uuid;
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

    public function testNew()
    {
        $uuid = IdentityGenerator::new();

        $this->assertInstanceOf(Uuid::class, $uuid);
    }

    public function testHashed()
    {
        $ns = new Uuid('e9dd9eee-435e-453d-8437-2919f4105a32');

        $uuid1 = IdentityGenerator::hashed($ns, 'my', 'hashed', 'uuid');
        $uuid2 = IdentityGenerator::hashed($ns, 'my.hashed.uuid');

        $this->assertTrue($uuid1->equals($uuid2));
    }
}
