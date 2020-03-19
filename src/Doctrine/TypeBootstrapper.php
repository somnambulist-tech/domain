<?php declare(strict_types=1);

namespace Somnambulist\Domain\Doctrine;

use Doctrine\DBAL\Types\Type;
use Somnambulist\Domain\Doctrine\Enumerations\Constructors\CountryConstructor;
use Somnambulist\Domain\Doctrine\Enumerations\Constructors\CurrencyConstructor;
use Somnambulist\Domain\Doctrine\Enumerations\Constructors\TypedEnumerableConstructor;
use Somnambulist\Domain\Doctrine\Enumerations\Serializers\CountrySerializer;
use Somnambulist\Domain\Doctrine\Enumerations\Serializers\CurrencySerializer;
use Somnambulist\Domain\Doctrine\Types;
use Somnambulist\Domain\Doctrine\Types\EnumerationBridge;
use Somnambulist\Domain\Entities\Types\Geography;
use Somnambulist\Domain\Entities\Types\Measure;

/**
 * Class TypeBootstrapper
 *
 * @package    Somnambulist\Domain\Doctrine
 * @subpackage Somnambulist\Domain\Doctrine\TypeBootstrapper
 */
class TypeBootstrapper
{

    public static array $types = [
        'json'       => Types\JsonCollectionType::class,
        'date'       => Types\DateTime\DateType::class,
        'datetime'   => Types\DateTime\DateTimeType::class,
        'datetimetz' => Types\DateTime\DateTimeTzType::class,
        'time'       => Types\DateTime\TimeType::class,
        'email'      => Types\Identity\EmailAddressType::class,
        'phone'      => Types\PhoneNumberType::class,
        'url'        => Types\Web\UrlType::class,
        'uuid'       => Types\Identity\UuidType::class,
        'identity'   => Types\Identity\IdType::class,
    ];

    private function __construct() {}

    public static function registerEnumerations(): void
    {
        EnumerationBridge::registerEnumTypes([
            'srid'          => new TypedEnumerableConstructor(Geography\Srid::class),
            'area_unit'     => new TypedEnumerableConstructor(Measure\AreaUnit::class),
            'distance_unit' => new TypedEnumerableConstructor(Measure\DistanceUnit::class),
            'country'       => [new CountryConstructor(), new CountrySerializer()],
            'currency'      => [new CurrencyConstructor(), new CurrencySerializer()],
        ]);
    }

    public static function registerEnumerable(string $type, callable $constructor, callable $serializer = null): void
    {
        EnumerationBridge::registerEnumType($type, $constructor, $serializer);
    }

    public static function registerType(string $type, string $class): void
    {
        Type::hasType($type) ? Type::overrideType($type, $class) : Type::addType($type, $class);
    }

    public static function registerTypes(array $types): void
    {
        foreach ($types as $type => $class) {
            static::registerType($type, $class);
        }
    }
}
