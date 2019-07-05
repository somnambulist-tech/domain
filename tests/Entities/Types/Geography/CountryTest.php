<?php

namespace Somnambulist\Domain\Tests\Entities\Types\Geography;

use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Entities\Types\Geography\Country;
use Somnambulist\Domain\Entities\Types\Geography\CountryCode;

/**
 * Class CountryTest
 *
 * @package    Somnambulist\Domain\Tests\Entities\Types\Geography
 * @subpackage Somnambulist\Domain\Tests\Entities\Types\Geography\CountryTest
 */
class CountryTest extends TestCase
{

    /**
     * @group value-objects
     * @group value-objects-country
     */
    public function testCreate()
    {
        $vo = Country::memberByKey('CAN');

        $this->assertEquals('Canada', $vo->toString());
        $this->assertEquals('CAN', $vo->code());
    }

    /**
     * @group value-objects
     * @group value-objects-country
     */
    public function testCreateStatically()
    {
        $vo = Country::memberByKey('USA');

        $this->assertEquals('United States of America', $vo->toString());
        $this->assertEquals('USA', $vo->code());
    }

    /**
     * @group value-objects
     * @group value-objects-country
     */
    public function testCanCastToString()
    {
        $vo = Country::memberByKey('CAN');

        $this->assertEquals('CAN', (string)$vo);
        $this->assertEquals('CAN', (string)$vo->code());
    }

    /**
     * @group value-objects
     * @group value-objects-country
     */
    public function testCanCompare()
    {
        $vo1 = Country::memberByKey('CAN');
        $vo2 = Country::memberByKey('USA');

        $this->assertTrue($vo1->equals($vo1));
        $this->assertFalse($vo2->equals($vo1));
    }
}
