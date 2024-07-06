<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Models\Types\Web;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\Web\IPV4Address;

#[Group('models')]
#[Group('models-types')]
class IPv4AddressTest extends TestCase
{
    public function testCreate()
    {
        $vo = new IPV4Address('192.168.0.1');

        $this->assertEquals('192.168.0.1', $vo->toString());
    }

    public function testCanCastToString()
    {
        $vo = new IPV4Address('192.168.0.1');

        $this->assertEquals('192.168.0.1', (string)$vo);
    }

    public function testCanCompare()
    {
        $vo1 = new IPV4Address('192.168.0.1');
        $vo2 = new IPV4Address('192.168.0.2');

        $this->assertTrue($vo1->equals($vo1));
        $this->assertFalse($vo2->equals($vo1));
    }
}
