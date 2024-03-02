<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Models\Types\DateTime;

use DateTimeZone;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\DateTime\TimeZone;

/**
 * @group      models
 * @group      models-types
 * @group      models-types-datetime
 */
class TimeZoneTest extends TestCase
{
    public function testCreate()
    {
        $vo = new TimeZone('America/Toronto');

        $this->assertEquals('America/Toronto', $vo->toString());
    }

    public function testCreateFromFactory()
    {
        $vo = TimeZone::create('America/Toronto');

        $this->assertEquals('America/Toronto', $vo->toString());
    }

    public function testCreateFromFactoryUsesSystemDefault()
    {
        $vo = TimeZone::create();

        $this->assertEquals(date_default_timezone_get(), $vo->toString());
    }

    public function testCanCastToString()
    {
        $vo = new TimeZone('America/Toronto');

        $this->assertEquals('America/Toronto', (string)$vo);
    }

    public function testCanGetNative()
    {
        $vo = new TimeZone('America/Toronto');

        $this->assertInstanceOf(DateTimeZone::class, $vo->toNative());
    }

    public function testCanCompareOtherObjects()
    {
        $vo1 = new TimeZone('America/Toronto');
        $vo2 = new TimeZone('America/New_York');

        $this->assertTrue($vo1->equals($vo1));
        $this->assertFalse($vo1->equals($vo2));
    }

    public function testCantSetArbitraryProperties()
    {
        $vo      = new TimeZone('America/Toronto');
        $vo->foo = 'bar';

        $this->assertObjectNotHasProperty('foo', $vo);
    }
}
