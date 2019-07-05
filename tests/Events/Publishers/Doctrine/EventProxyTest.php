<?php

namespace Somnambulist\Domain\Tests\Events\Publishers\Doctrine;

use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Events\Publishers\Doctrine\EventProxy;

/**
 * Class EventProxyTest
 *
 * @package    Somnambulist\Domain\Tests\Events\Publishers\Doctrine
 * @subpackage Somnambulist\Domain\Tests\Events\Publishers\Doctrine\EventProxyTest
 */
class EventProxyTest extends TestCase
{

    /**
     * @group publishers-doctrine-proxy
     */
    public function testCreate()
    {
        $proxy = EventProxy::createFrom(new \MyEntityCreatedEvent(['id' => '1234', 'name' => 'name', 'another' => 'another']));

        $this->assertInstanceOf(\MyEntityCreatedEvent::class, $proxy->proxiedEvent());
        $this->assertEquals('1234', $proxy->property('id'));
        $this->assertEquals('MyEntityCreated', $proxy->name());
    }

    /**
     * @group publishers-doctrine-proxy
     */
    public function testInvalidMethodRaisesException()
    {
        $proxy = EventProxy::createFrom(new \MyEntityCreatedEvent(['id' => '1234', 'name' => 'name', 'another' => 'another']));

        $this->expectException(\BadMethodCallException::class);
        $proxy->bob();
    }
}
