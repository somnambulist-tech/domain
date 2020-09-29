<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Entities\Types\Identity;

use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Domain\Entities\Types\Identity\EmailAddress;

/**
 * Class EmailAddressTest
 *
 * @package    Somnambulist\Components\Domain\Tests\Entities\Types\Identity
 * @subpackage Somnambulist\Components\Domain\Tests\Entities\Types\Identity\EmailAddressTest
 *
 * @group entities
 * @group entities-types
 * @group entities-types-email
 */
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

    public function testCantSetArbitraryProperties()
    {
        $vo = new EmailAddress('foo@example.com');
        $vo->foo = 'bar';

        $this->assertObjectNotHasAttribute('foo', $vo);
    }
}
