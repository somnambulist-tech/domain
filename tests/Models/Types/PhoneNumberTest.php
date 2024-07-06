<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Models\Types;

use Assert\InvalidArgumentException;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\PhoneNumber;

#[Group('models')]
#[Group('models-types')]
class PhoneNumberTest extends TestCase
{
    public function testCreate()
    {
        $vo = new PhoneNumber('+12345678901');

        $this->assertEquals('+12345678901', $vo->toString());
    }

    public function testCreateRequiresE164FormatNumber()
    {
        $this->expectException(InvalidArgumentException::class);

        new PhoneNumber('01234567890');
    }

    public function testCanCastToString()
    {
        $vo = new PhoneNumber('+12345678901');

        $this->assertEquals('+12345678901', (string)$vo);
    }

    public function testCanCompareInstances()
    {
        $vo1 = new PhoneNumber('+12345678901');
        $vo2 = new PhoneNumber('+32345678901');
        $vo3 = new PhoneNumber('+12345678901');


        $this->assertFalse($vo1->equals($vo2));
        $this->assertTrue($vo1->equals($vo3));
        $this->assertTrue($vo1->equals($vo1));
    }
}
