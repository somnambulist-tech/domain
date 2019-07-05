<?php

namespace Somnambulist\Domain\Tests\Entities\Types\Identity;

use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Entities\Types\Identity\EmailAddress;
use Somnambulist\Domain\Entities\Types\Identity\Uuid;

/**
 * Class UuidTest
 *
 * @package    Somnambulist\Domain\Tests\Entities\Types\Identity
 * @subpackage Somnambulist\Domain\Tests\Entities\Types\Identity\UuidTest
 */
class UuidTest extends TestCase
{

    /**
     * @group value-objects
     * @group value-objects-uuid
     */
    public function testCreate()
    {
        $vo = new Uuid($uuid = \Ramsey\Uuid\Uuid::uuid4());

        $this->assertEquals($uuid->toString(), $vo->toString());
    }

    /**
     * @group value-objects
     * @group value-objects-uuid
     */
    public function testCanCastToString()
    {
        $vo = new Uuid($uuid = \Ramsey\Uuid\Uuid::uuid4());

        $this->assertEquals($uuid->toString(), (string)$vo);
    }

    /**
     * @group value-objects
     * @group value-objects-uuid
     */
    public function testCanCompareInstances()
    {
        $vo1 = new Uuid(\Ramsey\Uuid\Uuid::uuid4());
        $vo2 = new Uuid(\Ramsey\Uuid\Uuid::uuid4());
        $vo3 = new Uuid(\Ramsey\Uuid\Uuid::uuid4());

        $this->assertFalse($vo1->equals($vo2));
        $this->assertFalse($vo2->equals($vo3));
        $this->assertTrue($vo1->equals($vo1));
    }

    /**
     * @group value-objects
     * @group value-objects-uuid
     */
    public function testCanCompareOtherInstances()
    {
        $vo1 = new Uuid(\Ramsey\Uuid\Uuid::uuid4());
        $vo2 = new EmailAddress('bob@example.com');

        $this->assertFalse($vo1->equals($vo2));
    }

    /**
     * @group value-objects
     * @group value-objects-uuid
     */
    public function testCantSetArbitraryProperties()
    {
        $vo = new Uuid(\Ramsey\Uuid\Uuid::uuid4());
        $vo->foo = 'bar';

        $this->assertObjectNotHasAttribute('foo', $vo);
    }
}
