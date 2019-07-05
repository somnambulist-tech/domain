<?php

namespace Somnambulist\Domain\Tests\Entities\Types\DateTime;

use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Entities\Types\DateTime\DateTime;
use Somnambulist\Domain\Entities\Types\Measure\AreaUnit;

/**
 * Class DateTimeTest
 *
 * @package    Somnambulist\Domain\Tests\Entities\Types\DateTime
 * @subpackage Somnambulist\Domain\Tests\Entities\Types\DateTime\DateTimeTest
 */
class DateTimeTest extends TestCase
{

    use Helpers;

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testCanCastToString()
    {
        $vo = new DateTime('2017-06-17 12:00:00', new \DateTimeZone('UTC'));

        $this->assertEquals('2017-06-17 12:00:00', (string)$vo);
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testCanTestEquality()
    {
        $vo1 = new DateTime();
        $vo2 = $vo1->clone();
        $vo3 = new DateTime('yesterday', new \DateTimeZone('Pacific/Honolulu'));

        $this->assertTrue($vo1->equals($vo2));
        $this->assertFalse($vo1->equals($vo3));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testCanCompareOtherObjects()
    {
        $vo1 = new DateTime();
        $vo2 = AreaUnit::SQ_M();

        $this->assertFalse($vo1->equals($vo2));
    }

    /**
     * @group value-objects
     * @group value-objects-date-time
     */
    public function testCantSetArbitraryProperties()
    {
        $vo = new DateTime();
        $vo->foo = 'bar';

        $this->assertObjectNotHasAttribute('foo', $vo);
    }
}
