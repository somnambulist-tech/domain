<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Utils;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\DateTime\DateTime;
use Somnambulist\Components\Models\Types\DateTime\TimeZone;
use Somnambulist\Components\Models\Types\Geography\Country;
use Somnambulist\Components\Models\Types\Identity\EmailAddress;
use Somnambulist\Components\Models\Types\Identity\Uuid;
use Somnambulist\Components\Models\Types\Money\Currency;
use Somnambulist\Components\Models\Types\Money\Money;
use Somnambulist\Components\Tests\Support\Stubs\Models\Order;
use Somnambulist\Components\Tests\Support\Stubs\Models\ValueObjects\Purchaser;
use Somnambulist\Components\Utils\EntityAccessor;

#[Group('utils')]
#[Group('utils-accessor')]
class EntityAccessorTest extends TestCase
{
    public function testExtractParentPrivateProperties()
    {
        $ret = EntityAccessor::extract(Country::memberByKey('CAN'));

        $this->assertEquals(['name' => 'Canada', 'key' => 'CAN', 'id' => 124, 'code2' => 'CA'], $ret);
    }

    public function testExtractComplexObjects()
    {
        $order = new Order(
            new Uuid('69747623-e51e-4503-8085-5a81ef4a9676'),
            new Purchaser('Foo Bar', new EmailAddress('foo.bar@example.com'), Country::memberByKey('CAN')),
            new Money(34.56, Currency::memberByKey('CAD')),
            $dt = DateTime::parse('now', new TimeZone('America/Toronto'))
        );
        $order->properties()->set('items', [
            ['name' => 'test one',],
            ['name' => 'test two',],
            ['name' => 'test three',],
        ]);

        $expected = [
            'id'         => null,
            'orderRef'   =>
                [
                    'value' => '69747623-e51e-4503-8085-5a81ef4a9676',
                ],
            'purchaser'  =>
                [
                    'name'    => 'Foo Bar',
                    'email'   =>
                        [
                            'value' => 'foo.bar@example.com',
                        ],
                    'country' =>
                        [
                            'name'  => 'Canada',
                            'key'   => 'CAN',
                            'id'    => 124,
                            'code2' => 'CA',
                        ],
                ],
            'total'      =>
                [
                    'amount'   => 34.56,
                    'currency' =>
                        [
                            'name' => 'Canadian Dollar',
                            'key'  => 'CAD',
                        ],
                ],
            'createdAt'  =>
                [
                    'defaultFormat' => 'Y-m-d H:i:s',
                    'time'          => $dt->format('Y-m-d H:i:s.u'),
                    'timezone'      => $dt->timezone()->toString(),
                ],
            'properties' =>
                [
                    'collectionClass' => 'Somnambulist\\Components\\Collection\\MutableCollection',
                    'items'           =>
                        [
                            'items' =>
                                [
                                    0 =>
                                        [
                                            'name' => 'test one',
                                        ],
                                    1 =>
                                        [
                                            'name' => 'test two',
                                        ],
                                    2 =>
                                        [
                                            'name' => 'test three',
                                        ],
                                ],
                        ],
                    'freezableClass'  => 'Somnambulist\\Components\\Collection\\FrozenCollection',
                    'proxies'         =>
                        [
                            'run' => 'Somnambulist\\Components\\Collection\\Utils\\RunProxy',
                            'map' => 'Somnambulist\\Components\\Collection\\Utils\\MapProxy',
                        ],
                    'type'            => null,
                ],
            'name'       => null,
        ];

        $this->assertEquals($expected, EntityAccessor::extract($order, recurseValues: true));
    }
}
