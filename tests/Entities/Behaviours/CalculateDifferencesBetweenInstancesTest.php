<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Entities\Behaviours;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Collection\MutableCollection;
use Somnambulist\Components\Domain\Entities\Types\DateTime\DateTime;
use Somnambulist\Components\Domain\Entities\Types\DateTime\TimeZone;
use Somnambulist\Components\Domain\Entities\Types\Geography\Country;
use Somnambulist\Components\Domain\Entities\Types\Identity\EmailAddress;
use Somnambulist\Components\Domain\Entities\Types\Identity\Uuid;
use Somnambulist\Components\Domain\Entities\Types\Money\Currency;
use Somnambulist\Components\Domain\Entities\Types\Money\Money;
use Somnambulist\Components\Domain\Tests\Support\Stubs\Models\Order;
use Somnambulist\Components\Domain\Tests\Support\Stubs\Models\ValueObjects\Purchaser;
use Somnambulist\Components\Domain\Utils\ObjectDiff;

/**
 * Class DiffTest
 *
 * @package    Somnambulist\Components\Domain\Tests\Entities\Behaviours
 * @subpackage Somnambulist\Components\Domain\Tests\Entities\Behaviours\DiffTest
 */
class CalculateDifferencesBetweenInstancesTest extends TestCase
{

    public function testDiff()
    {
        $v1 = new Purchaser('test', new EmailAddress('a@b.co'), Country::memberByKey('CAN'));
        $v2 = new Purchaser('tester', new EmailAddress('a@b.co'), Country::memberByKey('GBR'));

        $expected = [
            'name'    => [
                'mine'   => 'test',
                'theirs' => 'tester',
            ],
            'country' => [
                'id'    => [
                    'mine'   => 124,
                    'theirs' => 826,
                ],
                'code2' => [
                    'mine'   => 'CA',
                    'theirs' => 'GB',
                ],
                'name'  => [
                    'mine'   => 'Canada',
                    'theirs' => 'United Kingdom of Great Britain and Northern Ireland',
                ],
                'key'   => [
                    'mine'   => 'CAN',
                    'theirs' => 'GBR',
                ],
            ],
        ];

        $this->assertEquals($expected, $v1->diff($v2));
    }

    public function testIgnoresSameInstance()
    {
        $v1 = new Purchaser('test', new EmailAddress('a@b.co'), Country::memberByKey('CAN'));

        $expected = [];

        $this->assertEquals($expected, $v1->diff($v1));
    }

    public function testRequiresSameObjectTypeToDiff()
    {
        $o1 = new EmailAddress('a@b.co');
        $o2 = Country::memberByKey('CAN');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected instance of "Somnambulist\Components\Domain\Entities\Types\Identity\EmailAddress" to diff with, received "Somnambulist\Components\Domain\Entities\Types\Geography\Country"');

        (new ObjectDiff())->diff($o1, $o2);
    }

    public function testDiffOnObjectsWithPrivateParents()
    {
        $v1 = Country::memberByKey('CAN');
        $v2 = Country::memberByKey('GBR');

        $expected = [
            'name' => [
                'mine'   => 'Canada',
                'theirs' => 'United Kingdom of Great Britain and Northern Ireland',
            ],
            'key'  => [
                'mine'   => 'CAN',
                'theirs' => 'GBR',
            ],
            'id'    => [
                'mine'   => 124,
                'theirs' => 826,
            ],
            'code2' => [
                'mine'   => 'CA',
                'theirs' => 'GB',
            ],
        ];

        $this->assertEquals($expected, (new ObjectDiff())->diff($v1, $v2));
    }

    public function testExtendedDiff()
    {
        $o1 = new Order(
            new Uuid('69747623-e51e-4503-8085-5a81ef4a9676'),
            new Purchaser('Foo Bar', new EmailAddress('foo.bar@example.com'), Country::memberByKey('CAN')),
            new Money(34.56, Currency::memberByKey('CAD')),
            DateTime::parse('now', new TimeZone('America/Toronto'))
        );
        $o1->properties()->set('items', [
            ['name' => 'test one',],
            ['name' => 'test two',],
            ['name' => 'test three',],
        ]);

        $o2 = new Order(
            new Uuid('17d7fcba-0635-47e6-898c-2193f7cb20ec'),
            new Purchaser('Bar Baz', new EmailAddress('bar@example.com'), Country::memberByKey('CAN')),
            new Money(1234.98, Currency::memberByKey('CAD')),
            DateTime::parse('now', new TimeZone('America/Toronto'))
        );
        $o2->properties()->set('items', [
            ['name' => 'test one',],
            ['name' => 'test two',],
            ['name' => 'test three',],
        ]);

        $expected = [
            'orderRef'  => [
                'value' => [
                    'mine'   => '69747623-e51e-4503-8085-5a81ef4a9676',
                    'theirs' => '17d7fcba-0635-47e6-898c-2193f7cb20ec',
                ],
            ],
            'purchaser' => [
                'name'  => [
                    'mine'   => 'Foo Bar',
                    'theirs' => 'Bar Baz',
                ],
                'email' => [
                    'value' => [
                        'mine'   => 'foo.bar@example.com',
                        'theirs' => 'bar@example.com',
                    ],
                ],
            ],
            'total'     => [
                'amount' => [
                    'mine'   => 34.56,
                    'theirs' => 1234.98,
                ],
            ],
        ];

        $this->assertEquals($expected, $o1->diff($o2));
    }

    public function testExtendedDiffWithCollections()
    {
        $o1 = new MutableCollection([
            'items' => [
                ['name' => 'test one',],
                ['name' => 'test two',],
                ['name' => 'test three',],
            ],
        ]);
        $o2 = new MutableCollection([
            'items' => [
                ['name' => 'test one',],
                ['name' => 'test four',],
                ['name' => 'test three',],
            ],
        ]);


        $expected = [
            'items' => [
                'items' => [
                    1 => [
                        'name' => [
                            'mine'   => 'test two',
                            'theirs' => 'test four',
                        ],
                    ],
                ],
            ],
        ];

        $this->assertEquals($expected, (new ObjectDiff())->diff($o1, $o2));
    }
}
