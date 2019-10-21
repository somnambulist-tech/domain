<?php

namespace Somnambulist\Domain\Tests\Entities\Types\Identity;

use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Entities\Types\Identity\ExternalIdentity;
use Somnambulist\Domain\Entities\Types\Identity\EmailAddress;

/**
 * Class ExternalIdentityTest
 *
 * @package Somnambulist\Domain\Tests\Entities\Types\Identity
 * @subpackage Somnambulist\Domain\Tests\Entities\Types\Identity\ExternalIdentityTest
 */
class ExternalIdentityTest extends TestCase
{

    /**
     * @group value-objects
     * @group value-objects-external-id
     */
    public function testCreate()
    {
        $vo = new ExternalIdentity('Provider', 'ExternalIdentity');

        $this->assertEquals('Provider', $vo->provider());
        $this->assertEquals('ExternalIdentity', $vo->identity());
    }

    /**
     * @group value-objects
     * @group value-objects-external-id
     */
    public function testCanCastToString()
    {
        $vo = new ExternalIdentity('Provider', 'ExternalIdentity');

        $this->assertEquals('Provider' . ':ExternalIdentity', (string)$vo);
    }

    /**
     * @group value-objects
     * @group value-objects-external-id
     */
    public function testCanCompareInstances()
    {
        $vo1 = new ExternalIdentity('Provider', 'ExternalIdentity');
        $vo2 = new ExternalIdentity('Provider', 'AnotherTest');
        $vo3 = new ExternalIdentity('Provider', 'ExternalIdentity');

        $this->assertFalse($vo1->equals($vo2));
        $this->assertTrue($vo1->equals($vo3));
        $this->assertTrue($vo1->equals($vo1));
    }

    /**
     * @group value-objects
     * @group value-objects-external-id
     */
    public function testCanCompareOtherInstances()
    {
        $vo1 = new ExternalIdentity('Provider', 'ExternalIdentity');
        $vo2 = new EmailAddress('bob@example.com');

        $this->assertFalse($vo1->equals($vo2));
    }

    /**
     * @group value-objects
     * @group value-objects-external-id
     */
    public function testCantSetArbitraryProperties()
    {
        $vo = new ExternalIdentity('Provider', 'ExternalIdentity');
        $vo->foo = 'bar';

        $this->assertObjectNotHasAttribute('foo', $vo);
    }
}
