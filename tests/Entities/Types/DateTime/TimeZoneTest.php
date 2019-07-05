<?php

namespace Somnambulist\Domain\Tests\Entities\Types\DateTime;

use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Entities\Types\DateTime\TimeZone;

/**
 * Class TimeZoneTest
 *
 * @package    Somnambulist\Domain\Tests\Entities\Types\DateTime
 * @subpackage Somnambulist\Domain\Tests\Entities\Types\DateTime\TimeZoneTest
 */
class TimeZoneTest extends TestCase
{

    /**
     * @group value-objects
     * @group value-objects-time-zone
     */
    public function testCreate()
    {
        $vo = new TimeZone('America/Toronto');

        $this->assertEquals('America/Toronto', $vo->toString());
    }

    /**
     * @group value-objects
     * @group value-objects-time-zone
     */
    public function testCreateFromFactory()
    {
        $vo = TimeZone::create('America/Toronto');

        $this->assertEquals('America/Toronto', $vo->toString());
    }

    /**
     * @group value-objects
     * @group value-objects-time-zone
     */
    public function testCreateFromFactoryUsesSystemDefault()
    {
        $vo = TimeZone::create();

        $this->assertEquals(date_default_timezone_get(), $vo->toString());
    }

    /**
     * @group value-objects
     * @group value-objects-time-zone
     */
    public function testCanCastToString()
    {
        $vo = new TimeZone('America/Toronto');

        $this->assertEquals('America/Toronto', (string)$vo);
    }

    /**
     * @group value-objects
     * @group value-objects-time-zone
     */
    public function testCanGetNative()
    {
        $vo = new TimeZone('America/Toronto');

        $this->assertInstanceOf(\DateTimeZone::class, $vo->toNative());
    }

    /**
     * @group value-objects
     * @group value-objects-time-zone
     */
    public function testCanCompareOtherObjects()
    {
        $vo1 = new TimeZone('America/Toronto');
        $vo2 = new TimeZone('America/New_York');

        $this->assertTrue($vo1->equals($vo1));
        $this->assertFalse($vo1->equals($vo2));
    }

    /**
     * @group value-objects
     * @group value-objects-time-zone
     */
    public function testCantSetArbitraryProperties()
    {
        $vo = new TimeZone('America/Toronto');
        $vo->foo = 'bar';

        $this->assertObjectNotHasAttribute('foo', $vo);
    }
}
