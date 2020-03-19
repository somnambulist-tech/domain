<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Entities\Types\Geography;

use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Entities\Types\Geography\Country;

/**
 * Class CountryTest
 *
 * @package    Somnambulist\Domain\Tests\Entities\Types\Geography
 * @subpackage Somnambulist\Domain\Tests\Entities\Types\Geography\CountryTest
 *
 * @group entities
 * @group entities-types
 * @group entities-types-country
 */
class CountryTest extends TestCase
{

    public function testCreate()
    {
        $vo = Country::memberByKey('CAN');

        $this->assertEquals('Canada', $vo->name());
        $this->assertEquals('CAN', $vo->code());
        $this->assertEquals('CAN', $vo->toString());
    }

    public function testCreateStatically()
    {
        $vo = Country::memberByKey('USA');

        $this->assertEquals('United States of America', $vo->name());
        $this->assertEquals('USA', $vo->code());
    }

    public function testCanCastToString()
    {
        $vo = Country::memberByKey('CAN');

        $this->assertEquals('CAN', (string)$vo);
        $this->assertEquals('CAN', (string)$vo->code());
    }

    public function testCanCompare()
    {
        $vo1 = Country::memberByKey('CAN');
        $vo2 = Country::memberByKey('USA');

        $this->assertTrue($vo1->equals($vo1));
        $this->assertFalse($vo2->equals($vo1));
    }
}
