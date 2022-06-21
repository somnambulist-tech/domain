<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Models\Types\Geography;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\Geography\Country;

/**
 * @group models
 * @group models-types
 * @group models-types-country
 */
class CountryTest extends TestCase
{
    public function testCreate()
    {
        $vo = Country::memberByKey('CAN');

        $this->assertEquals('Canada', $vo->name());
        $this->assertEquals('CAN', $vo->code());
        $this->assertEquals('CAN', $vo->toString());
        $this->assertEquals('CA', $vo->code2());
        $this->assertEquals(124, $vo->id());
    }

    public function testCreateStatically()
    {
        $vo = Country::memberByKey('USA');

        $this->assertEquals('United States of America', $vo->name());
        $this->assertEquals('USA', $vo->code());
    }

    public function testCreateByIsoNum()
    {
        $vo = Country::getByISONumber(840);

        $this->assertEquals('United States of America', $vo->name());
        $this->assertEquals('USA', $vo->code());
    }

    public function testCreateByIso2()
    {
        $vo = Country::getByISO2Char('us');

        $this->assertEquals('United States of America', $vo->name());
        $this->assertEquals('USA', $vo->code());
    }

    public function testCreateByIso3()
    {
        $vo = Country::getByISO3Char('USA');

        $this->assertEquals('United States of America', $vo->name());
        $this->assertEquals('USA', $vo->code());
    }

    public function testCanCastToString()
    {
        $vo = Country::memberByKey('CAN');

        $this->assertEquals('CAN', (string)$vo);
    }

    public function testCanCompare()
    {
        $vo1 = Country::memberByKey('CAN');
        $vo2 = Country::memberByKey('USA');

        $this->assertTrue($vo1->equals($vo1));
        $this->assertFalse($vo2->equals($vo1));
    }
}
