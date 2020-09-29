<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Entities\Types\Identity;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Domain\Entities\Types\Identity\EmailAddress;
use Somnambulist\Components\Domain\Entities\Types\Identity\ExternalIdentity;

/**
 * Class ExternalIdentityTest
 *
 * @package Somnambulist\Components\Domain\Tests\Entities\Types\Identity
 * @subpackage Somnambulist\Components\Domain\Tests\Entities\Types\Identity\ExternalIdentityTest
 *
 * @group entities
 * @group entities-types
 * @group entities-types-external
 */
class ExternalIdentityTest extends TestCase
{

    public function testCreate()
    {
        $vo = new ExternalIdentity('Provider', 'ExternalIdentity');

        $this->assertEquals('Provider', $vo->provider());
        $this->assertEquals('ExternalIdentity', $vo->identity());
    }

    public function testCanCastToString()
    {
        $vo = new ExternalIdentity('Provider', 'ExternalIdentity');

        $this->assertEquals('Provider' . ':ExternalIdentity', (string)$vo);
    }

    public function testCanCompareInstances()
    {
        $vo1 = new ExternalIdentity('Provider', 'ExternalIdentity');
        $vo2 = new ExternalIdentity('Provider', 'AnotherTest');
        $vo3 = new ExternalIdentity('Provider', 'ExternalIdentity');

        $this->assertFalse($vo1->equals($vo2));
        $this->assertTrue($vo1->equals($vo3));
        $this->assertTrue($vo1->equals($vo1));
    }

    public function testCanCompareOtherInstances()
    {
        $vo1 = new ExternalIdentity('Provider', 'ExternalIdentity');
        $vo2 = new EmailAddress('bob@example.com');

        $this->assertFalse($vo1->equals($vo2));
    }

    public function testCantSetArbitraryProperties()
    {
        $vo = new ExternalIdentity('Provider', 'ExternalIdentity');
        $vo->foo = 'bar';

        $this->assertObjectNotHasAttribute('foo', $vo);
    }
}
