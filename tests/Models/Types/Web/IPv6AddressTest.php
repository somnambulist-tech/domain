<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Models\Types\Web;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\Web\IPV4Address;
use Somnambulist\Components\Models\Types\Web\IPV6Address;

#[Group('models')]
#[Group('models-types')]
class IPv6AddressTest extends TestCase
{
    public function testCreate()
    {
        $vo = new IPV6Address('::10');

        $this->assertEquals('::10', $vo->toString());
    }

    public function testCanCastToString()
    {
        $vo = new IPV6Address('::10');

        $this->assertEquals('::10', (string)$vo);
    }

    public function testCanCompare()
    {
        $vo1 = new IPV6Address('::10');
        $vo2 = new IPV4Address('192.168.0.2');

        $this->assertTrue($vo1->equals($vo1));
        $this->assertFalse($vo2->equals($vo1));
    }
}
