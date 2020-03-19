<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Entities\Types\Web;

use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Entities\Types\Web\IPv4Address;
use Somnambulist\Domain\Entities\Types\Web\IPV6Address;

/**
 * Class IPv6AddressTest
 *
 * @package    Somnambulist\Domain\Tests\Entities\Types\Web
 * @subpackage Somnambulist\Domain\Tests\Entities\Types\Web\IPv6AddressTest
 *
 * @group entities
 * @group entities-types
 * @group entities-types-ipv6
 */
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
        $vo2 = new IPv4Address('192.168.0.2');

        $this->assertTrue($vo1->equals($vo1));
        $this->assertFalse($vo2->equals($vo1));
    }
}
