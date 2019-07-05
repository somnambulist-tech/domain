<?php declare(strict_types=1);

namespace Somnambulist\Domain\Doctrine;

use Doctrine\DBAL\Types\Type;
use Somnambulist\Domain\Doctrine\Enumerations\Constructors\CountryEnumeration;
use Somnambulist\Domain\Doctrine\Enumerations\Constructors\CurrencyEnumeration;
use Somnambulist\Domain\Doctrine\Enumerations\Constructors\GenericEloquentEnumeration;
use Somnambulist\Domain\Doctrine\Enumerations\Serializers\CountrySerializer;
use Somnambulist\Domain\Doctrine\Enumerations\Serializers\CurrencySerializer;
use Somnambulist\Domain\Doctrine\Types;
use Somnambulist\Domain\Entities\Types\Geography;
use Somnambulist\Domain\Entities\Types\Measure;
use Somnambulist\Domain\Entities\Types\Money;

/**
 * Class Bootstrapper
 *
 * @package    Somnambulist\Domain\Doctrine
 * @subpackage Somnambulist\Domain\Doctrine\Bootstrapper
 */
class Bootstrapper
{

    private function __construct()
    {
    }

    public static function registerEnumerations(): void
    {
        $constructor = new GenericEloquentEnumeration();

        EnumerationBridge::registerEnumTypes([
            Geography\CountryCode::class => $constructor,
            Geography\Srid::class        => $constructor,
            Measure\AreaUnit::class      => $constructor,
            Measure\DistanceUnit::class  => $constructor,
            Money\CurrencyCode::class    => $constructor,

            Geography\Country::class => [new CountryEnumeration(), new CountrySerializer()],
            Money\Currency::class    => [new CurrencyEnumeration(), new CurrencySerializer()],
        ]);
    }

    /**
     * Register a custom type
     *
     * Checks if the type is already available and overrides it if set, or
     * adds it as the Doctrine handling does not allow this.
     *
     * @param string $type
     * @param string $class
     */
    public static function registerType(string $type, string $class): void
    {
        Type::hasType($type) ? Type::overrideType($type, $class) : Type::addType($type, $class);
    }

    public static function registerTypes(): void
    {
        $types = [
            'json'            => Types\JsonCollectionType::class,
            'jsonb'           => Types\JsonCollectionType::class,
            'json_collection' => Types\JsonCollectionType::class,
            'date'            => Types\DateTime\DateType::class,
            'datetime'        => Types\DateTime\DateTimeType::class,
            'datetimetz'      => Types\DateTime\DateTimeTzType::class,
            'time'            => Types\DateTime\TimeType::class,
        ];

        foreach ($types as $type => $class) {
            static::registerType($type, $class);
        }
    }

    public static function registerExtendedTypes(): void
    {
        $types = [
            'email' => Types\Identity\EmailAddressType::class,
            'phone' => Types\PhoneNumberType::class,
            'url'   => Types\Web\UrlType::class,
            'uuid'  => Types\Identity\UuidType::class,
        ];

        foreach ($types as $type => $class) {
            static::registerType($type, $class);
        }
    }
}
