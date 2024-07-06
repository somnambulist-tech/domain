<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Models\Types\Geography;

use Assert\AssertionFailedException;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\Geography\Srid;

#[Group('models')]
#[Group('models-types')]
class SridTest extends TestCase
{
    public function testCreate()
    {
        $vo = new Srid(4326);

        $this->assertEquals('4326', $vo->toString());
    }

    public function testCanCastToString()
    {
        $vo = new Srid(4326);

        $this->assertEquals('4326', (string)$vo);
    }

    public function testMustBeIntGreaterThanZero()
    {
        $this->expectException(AssertionFailedException::class);
        new Srid(0);
    }

    public function testMustBeIntGreaterThanZero2()
    {
        $this->expectException(AssertionFailedException::class);
        new Srid(-1);
    }
}
