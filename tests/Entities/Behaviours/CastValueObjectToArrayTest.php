<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Entities\Behaviours;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Domain\Entities\Types\Geography\Country;
use Somnambulist\Components\Domain\Entities\Types\Identity\EmailAddress;
use Somnambulist\Components\Domain\Tests\Support\Stubs\Models\ValueObjects\Purchaser;

/**
 * Class CastValueObjectToArrayTest
 *
 * @package    Somnambulist\Components\Domain\Tests\Entities\Behaviours
 * @subpackage Somnambulist\Components\Domain\Tests\Entities\Behaviours\CastValueObjectToArrayTest
 */
class CastValueObjectToArrayTest extends TestCase
{

    public function testToArray()
    {
        $vo = new Purchaser('test', new EmailAddress('a@b.co'), Country::memberByKey('CAN'));

        $expected = [
            'name'    => 'test',
            'email'   => ['value' => 'a@b.co'],
            'country' => ['name' => 'Canada', 'key' => 'CAN'],
        ];

        $this->assertEquals($expected, $vo->toArray());
    }
}
