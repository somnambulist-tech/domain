<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Models\Types\Identity;

use Assert\InvalidArgumentException;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\Identity\EmailAddress;

#[Group('models')]
#[Group('models-types')]
class EmailAddressTest extends TestCase
{
    public function testCreate()
    {
        $vo = new EmailAddress('foo@example.com');

        $this->assertEquals('foo@example.com', $vo->toString());
    }

    public function testCreateRaisesExceptionForInvalidArguments()
    {
        $this->expectException(InvalidArgumentException::class);

        new EmailAddress('foo');
    }

    public function testCanCastToString()
    {
        $vo = new EmailAddress('foo@example.com');

        $this->assertEquals('foo@example.com', (string)$vo);
    }

    public function testCanGetAccountComponent()
    {
        $vo = new EmailAddress('foo@example.com');

        $this->assertEquals('foo', $vo->account());
    }

    public function testCanGetDomainComponent()
    {
        $vo = new EmailAddress('foo@example.com');

        $this->assertEquals('example.com', $vo->domain());
    }

    public function testCanCompareInstances()
    {
        $vo1 = new EmailAddress('foo@example.com');
        $vo2 = new EmailAddress('foo.bar@example.com');
        $vo3 = new EmailAddress('foo@example.com');


        $this->assertFalse($vo1->equals($vo2));
        $this->assertTrue($vo1->equals($vo3));
        $this->assertTrue($vo1->equals($vo1));
    }
}
