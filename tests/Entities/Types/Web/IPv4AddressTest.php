<?php

namespace Somnambulist\Domain\Tests\Entities\Types\Web;

use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Entities\Types\Web\IPv4Address;

/**
 * Class IPv4AddressTest
 *
 * @package    Somnambulist\Domain\Tests\Entities\Types\Web
 * @subpackage Somnambulist\Domain\Tests\Entities\Types\Web\IPv4AddressTest
 */
class IPv4AddressTest extends TestCase
{

    /**
     * @group value-objects
     * @group value-objects-ipv4
     */
    public function testCreate()
    {
        $vo = new IPv4Address('192.168.0.1');

        $this->assertEquals('192.168.0.1', $vo->toString());
    }

    /**
     * @group value-objects
     * @group value-objects-ipv4
     */
    public function testCanCastToString()
    {
        $vo = new IPv4Address('192.168.0.1');

        $this->assertEquals('192.168.0.1', (string)$vo);
    }

    /**
     * @group value-objects
     * @group value-objects-ipv4
     */
    public function testCanCompare()
    {
        $vo1 = new IPv4Address('192.168.0.1');
        $vo2 = new IPv4Address('192.168.0.2');

        $this->assertTrue($vo1->equals($vo1));
        $this->assertFalse($vo2->equals($vo1));
    }
}
