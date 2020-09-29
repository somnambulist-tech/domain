<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Entities\Types\Money;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Domain\Entities\Types\Money\Currency;

/**
 * Class CurrencyTest
 *
 * @package    Somnambulist\Components\Domain\Tests\Entities\Types\Money
 * @subpackage Somnambulist\Components\Domain\Tests\Entities\Types\Money\CurrencyTest
 *
 * @group entities
 * @group entities-types
 * @group entities-types-currency
 */
class CurrencyTest extends TestCase
{

    public function testCreate()
    {
        $vo = Currency::memberByKey('CAD');

        $this->assertEquals('Canadian Dollar', $vo->name());
        $this->assertEquals('CAD', $vo->code());
        $this->assertEquals('CAD', $vo->toString());
        $this->assertEquals(2, $vo->precision());
    }

    public function testCreateGetsDefaultPrecision()
    {
        $vo = Currency::memberByKey('USD');

        $this->assertEquals(2, $vo->precision());
    }

    public function testCreateGetsSpecificPrecision()
    {
        $vo = Currency::memberByKey('BHD');

        $this->assertEquals(3, $vo->precision());

        $vo = Currency::memberByKey('CLF');

        $this->assertEquals(4, $vo->precision());

        $vo = Currency::memberByKey('VND');

        $this->assertEquals(0, $vo->precision());
    }

    public function testCreateStatically()
    {
        $vo = Currency::memberByKey('GBP');

        $this->assertEquals('Pound Sterling', $vo->name());
        $this->assertEquals('GBP', $vo->code());
    }

    public function testCanCastToString()
    {
        $vo = Currency::memberByKey('CAD');

        $this->assertEquals('CAD', (string)$vo);
        $this->assertEquals('CAD', (string)$vo->code());
    }

    public function testCanCompare()
    {
        $vo1 = Currency::memberByKey('CAD');
        $vo2 = Currency::memberByKey('USD');

        $this->assertTrue($vo1->equals($vo1));
        $this->assertFalse($vo2->equals($vo1));
    }
}
