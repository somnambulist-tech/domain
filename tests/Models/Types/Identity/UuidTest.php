<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Models\Types\Identity;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\Identity\EmailAddress;
use Somnambulist\Components\Models\Types\Identity\Uuid;

/**
 * @group models
 * @group models-types
 * @group models-types-uuid
 */
class UuidTest extends TestCase
{
    public function testCreate()
    {
        $vo = new Uuid($uuid = \Ramsey\Uuid\Uuid::uuid4()->toString());

        $this->assertEquals($uuid, $vo->toString());
    }

    public function testCanCastToString()
    {
        $vo = new Uuid($uuid = \Ramsey\Uuid\Uuid::uuid4()->toString());

        $this->assertEquals($uuid, (string)$vo);
    }

    public function testCanCompareInstances()
    {
        $vo1 = new Uuid(\Ramsey\Uuid\Uuid::uuid4()->toString());
        $vo2 = new Uuid(\Ramsey\Uuid\Uuid::uuid4()->toString());
        $vo3 = new Uuid(\Ramsey\Uuid\Uuid::uuid4()->toString());

        $this->assertFalse($vo1->equals($vo2));
        $this->assertFalse($vo2->equals($vo3));
        $this->assertTrue($vo1->equals($vo1));
    }

    public function testCanCompareOtherInstances()
    {
        $vo1 = new Uuid(\Ramsey\Uuid\Uuid::uuid4()->toString());
        $vo2 = new EmailAddress('bob@example.com');

        $this->assertFalse($vo1->equals($vo2));
    }

    public function testCantSetArbitraryProperties()
    {
        $vo = new Uuid(\Ramsey\Uuid\Uuid::uuid4()->toString());
        $vo->foo = 'bar';

        $this->assertObjectNotHasProperty('foo', $vo);
    }
}
