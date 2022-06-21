<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Models\Types\Auth;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\Auth\PublicPrivateKey;
use Somnambulist\Components\Models\Types\Identity\EmailAddress;

/**
 * @group models
 * @group models-types
 * @group models-types-pubkey
 */
class PublicPrivateKeyTest extends TestCase
{
    const TEST_STRING = 'Somnambulist\Components\Models\Types';

    public function testCreate()
    {
        $vo = new PublicPrivateKey(static::TEST_STRING, 'PublicPrivateKeyTest');

        $this->assertEquals(static::TEST_STRING, $vo->publicKey());
        $this->assertEquals('PublicPrivateKeyTest', $vo->privateKey());
    }

    public function testCanCastToString()
    {
        $vo = new PublicPrivateKey(static::TEST_STRING, 'PublicPrivateKeyTest');

        $this->assertEquals(static::TEST_STRING, (string)$vo);
    }

    public function testCanCompareInstances()
    {
        $vo1 = new PublicPrivateKey(static::TEST_STRING, 'PublicPrivateKeyTest');
        $vo2 = new PublicPrivateKey(static::TEST_STRING, 'AnotherTest');
        $vo3 = new PublicPrivateKey(static::TEST_STRING, 'PublicPrivateKeyTest');

        $this->assertFalse($vo1->equals($vo2));
        $this->assertTrue($vo1->equals($vo3));
        $this->assertTrue($vo1->equals($vo1));
    }

    public function testCanCompareOtherInstances()
    {
        $vo1 = new PublicPrivateKey(static::TEST_STRING, 'PublicPrivateKeyTest');
        $vo2 = new EmailAddress('bob@example.com');

        $this->assertFalse($vo1->equals($vo2));
    }
    
    public function testCantSetArbitraryProperties()
    {
        $vo = new PublicPrivateKey(static::TEST_STRING, 'PublicPrivateKeyTest');
        $vo->foo = 'bar';

        $this->assertObjectNotHasAttribute('foo', $vo);
    }
}
