<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Doctrine;

use Doctrine\DBAL\Types\Type;
use Somnambulist\Components\Domain\Doctrine\Enumerations\Constructors\CountryConstructor;
use Somnambulist\Components\Domain\Doctrine\Enumerations\Constructors\CurrencyConstructor;
use Somnambulist\Components\Domain\Doctrine\Enumerations\Constructors\TypedEnumerableConstructor;
use Somnambulist\Components\Domain\Doctrine\Enumerations\Serializers\CountrySerializer;
use Somnambulist\Components\Domain\Doctrine\Enumerations\Serializers\CurrencySerializer;
use Somnambulist\Components\Domain\Doctrine\Types;
use Somnambulist\Components\Domain\Doctrine\Types\EnumerationBridge;
use Somnambulist\Components\Domain\Entities\Types\Geography;
use Somnambulist\Components\Domain\Entities\Types\Measure;

/**
 * Class TypeBootstrapper
 *
 * @package    Somnambulist\Components\Domain\Doctrine
 * @subpackage Somnambulist\Components\Domain\Doctrine\TypeBootstrapper
 */
class TypeBootstrapper
{
    public static array $types = [
        'date'       => Types\DateTime\DateType::class,
        'datetime'   => Types\DateTime\DateTimeType::class,
        'datetimetz' => Types\DateTime\DateTimeTzType::class,
        'time'       => Types\DateTime\TimeType::class,
        'password'   => Types\Auth\PasswordType::class,
        'email'      => Types\Identity\EmailAddressType::class,
        'identity'   => Types\Identity\IdType::class,
        'uuid'       => Types\Identity\UuidType::class,
        'json'       => Types\JsonCollectionType::class,
        'phone'      => Types\PhoneNumberType::class,
        'url'        => Types\Web\UrlType::class,
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
