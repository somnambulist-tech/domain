<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Models\Types\Identity;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\Identity\EmailAddress;
use Somnambulist\Components\Models\Types\Identity\ExternalIdentity;

#[Group('models')]
#[Group('models-types')]
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
}
