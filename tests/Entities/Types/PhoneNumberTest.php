<?php

namespace Somnambulist\Domain\Tests\Entities\Types\Identity;

use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Entities\Types\PhoneNumber;

/**
 * Class PhoneNumberTest
 *
 * @package    Somnambulist\Domain\Tests\Entities\Types
 * @subpackage Somnambulist\Domain\Tests\Entities\Types\PhoneNumberTest
 */
class PhoneNumberTest extends TestCase
{

    /**
     * @group value-objects
     * @group value-objects-phone-number
     */
    public function testCreate()
    {
        $vo = new PhoneNumber('+12345678901');

        $this->assertEquals('+12345678901', $vo->toString());
    }

    /**
     * @group value-objects
     * @group value-objects-phone-number
     */
    public function testCreateRequiresE164FormatNumber()
    {
        $this->expectException(InvalidArgumentException::class);

        new PhoneNumber('01234567890');
    }

    /**
     * @group value-objects
     * @group value-objects-phone-number
     */
    public function testCanCastToString()
    {
        $vo = new PhoneNumber('+12345678901');

        $this->assertEquals('+12345678901', (string)$vo);
    }

    /**
     * @group value-objects
     * @group value-objects-phone-number
     */
    public function testCanCompareInstances()
    {
        $vo1 = new PhoneNumber('+12345678901');
        $vo2 = new PhoneNumber('+32345678901');
        $vo3 = new PhoneNumber('+12345678901');


        $this->assertFalse($vo1->equals($vo2));
        $this->assertTrue($vo1->equals($vo3));
        $this->assertTrue($vo1->equals($vo1));
    }

    /**
     * @group value-objects
     * @group value-objects-phone-number
     */
    public function testCantSetArbitraryProperties()
    {
        $vo = new PhoneNumber('+12345678901');
        $vo->foo = 'bar';

        $this->assertObjectNotHasAttribute('foo', $vo);
    }
}
