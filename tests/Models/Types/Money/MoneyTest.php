<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Models\Types\Money;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\Money\Currency;
use Somnambulist\Components\Models\Types\Money\Money;

#[Group('models')]
#[Group('models-types')]
class MoneyTest extends TestCase
{
    public function testCreate()
    {
        $vo = new Money(23.458, Currency::memberByKey('CAD'));

        $this->assertEquals('CAD 23.46', $vo->toString());
        $this->assertEquals(23.458, $vo->amount());
        $this->assertEquals('23.46', $vo->rounded());
    }

    public function testCreateStatically()
    {
        $vo = Money::create(23.458, 'CAD');

        $this->assertEquals('CAD 23.46', $vo->toString());
        $this->assertEquals(23.458, $vo->amount());
        $this->assertEquals('23.46', $vo->rounded());
    }

    public function testCanCastToString()
    {
        $vo = new Money(23.458, Currency::memberByKey('CAD'));

        $this->assertEquals('CAD 23.46', (string)$vo);
        $this->assertEquals('CAD', (string)$vo->currency());
    }

    public function testCanCompare()
    {
        $vo1 = new Money(23.458, Currency::memberByKey('CAD'));
        $vo2 = new Money(23.458, Currency::memberByKey('USD'));

        $this->assertTrue($vo1->equals($vo1));
        $this->assertFalse($vo2->equals($vo1));
    }
}
