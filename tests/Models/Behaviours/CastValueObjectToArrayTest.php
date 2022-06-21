<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Models\Behaviours;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\Geography\Country;
use Somnambulist\Components\Models\Types\Identity\EmailAddress;
use Somnambulist\Components\Tests\Support\Stubs\Models\ValueObjects\Purchaser;

class CastValueObjectToArrayTest extends TestCase
{
    public function testToArray()
    {
        $vo = new Purchaser('test', new EmailAddress('a@b.co'), Country::memberByKey('CAN'));

        $expected = [
            'name'    => 'test',
            'email'   => ['value' => 'a@b.co'],
            'country' => ['name' => 'Canada', 'key' => 'CAN', 'id' => 124, 'code2' => 'CA'],
        ];

        $this->assertEquals($expected, $vo->toArray());
    }
}
