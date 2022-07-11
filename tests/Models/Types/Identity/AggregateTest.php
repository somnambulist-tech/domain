<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Models\Types\Identity;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\Identity\Aggregate;
use Somnambulist\Components\Models\Types\Identity\EmailAddress;

/**
 * @group models
 * @group models-types
 * @group models-types-aggregate
 */
class AggregateTest extends TestCase
{
    public function testCreate()
    {
        $vo = new Aggregate(__CLASS__, '5244f8c4-e984-4797-bee4-c9616655f3d6');

        $this->assertEquals(__CLASS__, $vo->class());
        $this->assertEquals('5244f8c4-e984-4797-bee4-c9616655f3d6', $vo->identity());
    }

    public function testCanCastToString()
    {
        $vo = new Aggregate(__CLASS__, '5244f8c4-e984-4797-bee4-c9616655f3d6');

        $this->assertEquals(__CLASS__ . ':5244f8c4-e984-4797-bee4-c9616655f3d6', (string)$vo);
    }

    public function testCanCompareInstances()
    {
        $vo1 = new Aggregate(__CLASS__, '5244f8c4-e984-4797-bee4-c9616655f3d6');
        $vo2 = new Aggregate(__CLASS__, '82eaac38-b320-490f-a950-5bad48c94045');
        $vo3 = new Aggregate(__CLASS__, '5244f8c4-e984-4797-bee4-c9616655f3d6');

        $this->assertFalse($vo1->equals($vo2));
        $this->assertTrue($vo1->equals($vo3));
        $this->assertTrue($vo1->equals($vo1));
    }

    public function testCanCompareOtherInstances()
    {
        $vo1 = new Aggregate(__CLASS__, '5244f8c4-e984-4797-bee4-c9616655f3d6');
        $vo2 = new EmailAddress('bob@example.com');

        $this->assertFalse($vo1->equals($vo2));
    }

    public function testCantSetArbitraryProperties()
    {
        $vo = new Aggregate(__CLASS__, '5244f8c4-e984-4797-bee4-c9616655f3d6');
        $vo->foo = 'bar';

        $this->assertObjectNotHasAttribute('foo', $vo);
    }
}
