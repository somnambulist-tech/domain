<?php

namespace Somnambulist\Domain\Tests\Entities\Types\Money;

use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Entities\Types\Money\Currency;

/**
 * Class CurrencyTest
 *
 * @package    Somnambulist\Domain\Tests\Entities\Types\Money
 * @subpackage Somnambulist\Domain\Tests\Entities\Types\Money\CurrencyTest
 */
class CurrencyTest extends TestCase
{

    /**
     * @group value-objects
     * @group value-objects-country
     */
    public function testCreate()
    {
        $vo = Currency::memberByKey('CAD');

        $this->assertEquals('Canadian Dollar', $vo->toString());
        $this->assertEquals('CAD', $vo->code());
        $this->assertEquals(2, $vo->precision());
    }

    /**
     * @group value-objects
     * @group value-objects-country
     */
    public function testCreateGetsDefaultPrecision()
    {
        $vo = Currency::memberByKey('USD');

        $this->assertEquals(2, $vo->precision());
    }

    /**
     * @group value-objects
     * @group value-objects-country
     */
    public function testCreateGetsSpecificPrecision()
    {
        $vo = Currency::memberByKey('BHD');

        $this->assertEquals(3, $vo->precision());

        $vo = Currency::memberByKey('CLF');

        $this->assertEquals(4, $vo->precision());

        $vo = Currency::memberByKey('VND');

        $this->assertEquals(0, $vo->precision());
    }

    /**
     * @group value-objects
     * @group value-objects-country
     */
    public function testCreateStatically()
    {
        $vo = Currency::memberByKey('GBP');

        $this->assertEquals('Pound Sterling', $vo->toString());
        $this->assertEquals('GBP', $vo->code());
    }

    /**
     * @group value-objects
     * @group value-objects-country
     */
    public function testCanCastToString()
    {
        $vo = Currency::memberByKey('CAD');

        $this->assertEquals('CAD', (string)$vo);
        $this->assertEquals('CAD', (string)$vo->code());
    }

    /**
     * @group value-objects
     * @group value-objects-country
     */
    public function testCanCompare()
    {
        $vo1 = Currency::memberByKey('CAD');
        $vo2 = Currency::memberByKey('USD');

        $this->assertTrue($vo1->equals($vo1));
        $this->assertFalse($vo2->equals($vo1));
    }
}
