<?php declare(strict_types=1);
# temporary aliases for BC 4 -> 5
class_alias('Somnambulist\Components\Commands\AbstractCommand', 'Somnambulist\Components\Domain\Commands\AbstractCommand');
class_alias('Somnambulist\Components\Commands\Adapters\MessengerCommandBus', 'Somnambulist\Components\Domain\Commands\Adapters\MessengerCommandBus');
class_alias('Somnambulist\Components\Commands\CommandBus', 'Somnambulist\Components\Domain\Commands\CommandBus');
class_alias('Somnambulist\Components\Doctrine\AbstractModelLocator', 'Somnambulist\Components\Domain\Doctrine\AbstractEntityLocator');
class_alias('Somnambulist\Components\Doctrine\AbstractServiceModelLocator', 'Somnambulist\Components\Domain\Doctrine\AbstractServiceEntityLocator');
class_alias('Somnambulist\Components\Doctrine\Behaviours\EntityLocator\FindByName', 'Somnambulist\Components\Domain\Doctrine\Behaviours\EntityLocator\FindByName');
class_alias('Somnambulist\Components\Doctrine\Behaviours\EntityLocator\FindBySlug', 'Somnambulist\Components\Domain\Doctrine\Behaviours\EntityLocator\FindBySlug');
class_alias('Somnambulist\Components\Doctrine\Behaviours\EntityLocator\FindByUUID', 'Somnambulist\Components\Domain\Doctrine\Behaviours\EntityLocator\FindByUUID');
class_alias('Somnambulist\Components\Doctrine\Behaviours\EntityLocator\FindOrFail', 'Somnambulist\Components\Domain\Doctrine\Behaviours\EntityLocator\FindOrFail');
class_alias('Somnambulist\Components\Doctrine\Behaviours\EntityLocator\HasJoinAlias', 'Somnambulist\Components\Domain\Doctrine\Behaviours\EntityLocator\HasJoinAlias');
class_alias('Somnambulist\Components\Doctrine\Behaviours\EntityLocator\Paginate', 'Somnambulist\Components\Domain\Doctrine\Behaviours\EntityLocator\Paginate');
class_alias('Somnambulist\Components\Doctrine\Behaviours\QueryBuilder\HasGroupByColumn', 'Somnambulist\Components\Domain\Doctrine\Behaviours\QueryBuilder\HasGroupByColumn');
class_alias('Somnambulist\Components\Doctrine\Behaviours\QueryBuilder\HasJoinAlias', 'Somnambulist\Components\Domain\Doctrine\Behaviours\QueryBuilder\HasJoinAlias');
class_alias('Somnambulist\Components\Doctrine\Behaviours\QueryBuilder\HasSelectColumn', 'Somnambulist\Components\Domain\Doctrine\Behaviours\QueryBuilder\HasSelectColumn');
class_alias('Somnambulist\Components\Doctrine\Enumerations\Constructors\CountryConstructor', 'Somnambulist\Components\Domain\Doctrine\Enumerations\Constructors\CountryConstructor');
class_alias('Somnambulist\Components\Doctrine\Enumerations\Constructors\CurrencyConstructor', 'Somnambulist\Components\Domain\Doctrine\Enumerations\Constructors\CurrencyConstructor');
class_alias('Somnambulist\Components\Doctrine\Enumerations\Constructors\NullableTypedEnumeratorConstructor', 'Somnambulist\Components\Domain\Doctrine\Enumerations\Constructors\NullableTypedEnumeratorConstructor');
class_alias('Somnambulist\Components\Doctrine\Enumerations\Constructors\TypedEnumerableConstructor', 'Somnambulist\Components\Domain\Doctrine\Enumerations\Constructors\TypedEnumerableConstructor');
class_alias('Somnambulist\Components\Doctrine\Enumerations\Constructors\TypedMultitonConstructor', 'Somnambulist\Components\Domain\Doctrine\Enumerations\Constructors\TypedMultitonConstructor');
class_alias('Somnambulist\Components\Doctrine\Enumerations\Serializers\CountrySerializer', 'Somnambulist\Components\Domain\Doctrine\Enumerations\Serializers\CountrySerializer');
class_alias('Somnambulist\Components\Doctrine\Enumerations\Serializers\CurrencySerializer', 'Somnambulist\Components\Domain\Doctrine\Enumerations\Serializers\CurrencySerializer');
class_alias('Somnambulist\Components\Doctrine\Functions\Postgres\CastToFunction', 'Somnambulist\Components\Domain\Doctrine\Functions\Postgres\CastToFunction');
class_alias('Somnambulist\Components\Doctrine\Functions\Postgres\IlikeFunction', 'Somnambulist\Components\Domain\Doctrine\Functions\Postgres\IlikeFunction');
class_alias('Somnambulist\Components\Doctrine\Functions\Postgres\ReplaceFunction', 'Somnambulist\Components\Domain\Doctrine\Functions\Postgres\ReplaceFunction');
class_alias('Somnambulist\Components\Doctrine\Functions\TypeFunction', 'Somnambulist\Components\Domain\Doctrine\Functions\TypeFunction');
class_alias('Somnambulist\Components\Doctrine\Paginator', 'Somnambulist\Components\Domain\Doctrine\Paginator');
class_alias('Somnambulist\Components\Doctrine\TypeBootstrapper', 'Somnambulist\Components\Domain\Doctrine\TypeBootstrapper');
class_alias('Somnambulist\Components\Doctrine\Types\AbstractIdentityType', 'Somnambulist\Components\Domain\Doctrine\Types\AbstractIdentityType');
class_alias('Somnambulist\Components\Doctrine\Types\AbstractValueObjectType', 'Somnambulist\Components\Domain\Doctrine\Types\AbstractValueObjectType');
class_alias('Somnambulist\Components\Doctrine\Types\Auth\PasswordType', 'Somnambulist\Components\Domain\Doctrine\Types\Auth\PasswordType');
class_alias('Somnambulist\Components\Doctrine\Types\DateTime\DateTimeType', 'Somnambulist\Components\Domain\Doctrine\Types\DateTime\DateTimeType');
class_alias('Somnambulist\Components\Doctrine\Types\DateTime\DateTimeTzType', 'Somnambulist\Components\Domain\Doctrine\Types\DateTime\DateTimeTzType');
class_alias('Somnambulist\Components\Doctrine\Types\DateTime\DateType', 'Somnambulist\Components\Domain\Doctrine\Types\DateTime\DateType');
class_alias('Somnambulist\Components\Doctrine\Types\DateTime\TimeType', 'Somnambulist\Components\Domain\Doctrine\Types\DateTime\TimeType');
class_alias('Somnambulist\Components\Doctrine\Types\EnumerationBridge', 'Somnambulist\Components\Domain\Doctrine\Types\EnumerationBridge');
class_alias('Somnambulist\Components\Doctrine\Types\Identity\EmailAddressType', 'Somnambulist\Components\Domain\Doctrine\Types\Identity\EmailAddressType');
class_alias('Somnambulist\Components\Doctrine\Types\Identity\IdType', 'Somnambulist\Components\Domain\Doctrine\Types\Identity\IdType');
class_alias('Somnambulist\Components\Doctrine\Types\Identity\UuidType', 'Somnambulist\Components\Domain\Doctrine\Types\Identity\UuidType');
class_alias('Somnambulist\Components\Doctrine\Types\JsonCollectionType', 'Somnambulist\Components\Domain\Doctrine\Types\JsonCollectionType');
class_alias('Somnambulist\Components\Doctrine\Types\PhoneNumberType', 'Somnambulist\Components\Domain\Doctrine\Types\PhoneNumberType');
class_alias('Somnambulist\Components\Doctrine\Types\Web\IPV4AddressType', 'Somnambulist\Components\Domain\Doctrine\Types\Web\IPV4AddressType');
class_alias('Somnambulist\Components\Doctrine\Types\Web\IPV6AddressType', 'Somnambulist\Components\Domain\Doctrine\Types\Web\IPV6AddressType');
class_alias('Somnambulist\Components\Doctrine\Types\Web\UrlType', 'Somnambulist\Components\Domain\Doctrine\Types\Web\UrlType');
class_alias('Somnambulist\Components\Models\AbstractEntity', 'Somnambulist\Components\Domain\Entities\AbstractEntity');
class_alias('Somnambulist\Components\Models\AbstractEntityCollection', 'Somnambulist\Components\Domain\Entities\AbstractEntityCollection');
class_alias('Somnambulist\Components\Models\AbstractEnumeration', 'Somnambulist\Components\Domain\Entities\AbstractEnumeration');
class_alias('Somnambulist\Components\Models\AbstractMultiton', 'Somnambulist\Components\Domain\Entities\AbstractMultiton');
class_alias('Somnambulist\Components\Models\AbstractSurrogateEntity', 'Somnambulist\Components\Domain\Entities\AbstractSurrogateEntity');
class_alias('Somnambulist\Components\Models\AbstractSurrogateEntityCollection', 'Somnambulist\Components\Domain\Entities\AbstractSurrogateEntityCollection');
class_alias('Somnambulist\Components\Models\AbstractValueObject', 'Somnambulist\Components\Domain\Entities\AbstractValueObject');
class_alias('Somnambulist\Components\Models\AggregateRoot', 'Somnambulist\Components\Domain\Entities\AggregateRoot');
class_alias('Somnambulist\Components\Models\Behaviours\AggregateEntityCollectionHelper', 'Somnambulist\Components\Domain\Entities\Behaviours\AggregateEntityCollectionHelper');
class_alias('Somnambulist\Components\Models\Behaviours\CalculateDifferenceBetweenInstances', 'Somnambulist\Components\Domain\Entities\Behaviours\CalculateDifferenceBetweenInstances');
class_alias('Somnambulist\Components\Models\Behaviours\CastValueObjectToArray', 'Somnambulist\Components\Domain\Entities\Behaviours\CastValueObjectToArray');
class_alias('Somnambulist\Components\Models\Contracts\CanCastToString', 'Somnambulist\Components\Domain\Entities\Contracts\CanCastToString');
class_alias('Somnambulist\Components\Models\Contracts\CanTestEquality', 'Somnambulist\Components\Domain\Entities\Contracts\CanTestEquality');
class_alias('Somnambulist\Components\Models\Contracts\ValueObject', 'Somnambulist\Components\Domain\Entities\Contracts\ValueObject');
class_alias('Somnambulist\Components\Models\Exceptions\EntityNotFoundException', 'Somnambulist\Components\Domain\Entities\Exceptions\EntityNotFoundException');
class_alias('Somnambulist\Components\Models\Exceptions\InvalidDomainConstraintException', 'Somnambulist\Components\Domain\Entities\Exceptions\InvalidDomainConstraintException');
class_alias('Somnambulist\Components\Models\Exceptions\InvalidDomainRelationshipException', 'Somnambulist\Components\Domain\Entities\Exceptions\InvalidDomainRelationshipException');
class_alias('Somnambulist\Components\Models\Exceptions\InvalidDomainStateException', 'Somnambulist\Components\Domain\Entities\Exceptions\InvalidDomainStateException');
class_alias('Somnambulist\Components\Models\Types\AbstractType', 'Somnambulist\Components\Domain\Entities\Types\AbstractType');
class_alias('Somnambulist\Components\Models\Types\Auth\Password', 'Somnambulist\Components\Domain\Entities\Types\Auth\Password');
class_alias('Somnambulist\Components\Models\Types\Auth\PublicPrivateKey', 'Somnambulist\Components\Domain\Entities\Types\Auth\PublicPrivateKey');
class_alias('Somnambulist\Components\Models\Types\DateTime\Behaviours\Comparable', 'Somnambulist\Components\Domain\Entities\Types\DateTime\Behaviours\Comparable');
class_alias('Somnambulist\Components\Models\Types\DateTime\Behaviours\Factory', 'Somnambulist\Components\Domain\Entities\Types\DateTime\Behaviours\Factory');
class_alias('Somnambulist\Components\Models\Types\DateTime\Behaviours\Modifiers', 'Somnambulist\Components\Domain\Entities\Types\DateTime\Behaviours\Modifiers');
class_alias('Somnambulist\Components\Models\Types\DateTime\Behaviours\Shifters', 'Somnambulist\Components\Domain\Entities\Types\DateTime\Behaviours\Shifters');
class_alias('Somnambulist\Components\Models\Types\DateTime\Behaviours\Stringable', 'Somnambulist\Components\Domain\Entities\Types\DateTime\Behaviours\Stringable');
class_alias('Somnambulist\Components\Models\Types\DateTime\DateTime', 'Somnambulist\Components\Domain\Entities\Types\DateTime\DateTime');
class_alias('Somnambulist\Components\Models\Types\DateTime\TimeZone', 'Somnambulist\Components\Domain\Entities\Types\DateTime\TimeZone');
class_alias('Somnambulist\Components\Models\Types\Geography\Coordinate', 'Somnambulist\Components\Domain\Entities\Types\Geography\Coordinate');
class_alias('Somnambulist\Components\Models\Types\Geography\Country', 'Somnambulist\Components\Domain\Entities\Types\Geography\Country');
class_alias('Somnambulist\Components\Models\Types\Geography\Srid', 'Somnambulist\Components\Domain\Entities\Types\Geography\Srid');
class_alias('Somnambulist\Components\Models\Types\Identity\AbstractIdentity', 'Somnambulist\Components\Domain\Entities\Types\Identity\AbstractIdentity');
class_alias('Somnambulist\Components\Models\Types\Identity\Aggregate', 'Somnambulist\Components\Domain\Entities\Types\Identity\Aggregate');
class_alias('Somnambulist\Components\Models\Types\Identity\EmailAddress', 'Somnambulist\Components\Domain\Entities\Types\Identity\EmailAddress');
class_alias('Somnambulist\Components\Models\Types\Identity\ExternalIdentity', 'Somnambulist\Components\Domain\Entities\Types\Identity\ExternalIdentity');
class_alias('Somnambulist\Components\Models\Types\Identity\Id', 'Somnambulist\Components\Domain\Entities\Types\Identity\Id');
class_alias('Somnambulist\Components\Models\Types\Identity\Uuid', 'Somnambulist\Components\Domain\Entities\Types\Identity\Uuid');
class_alias('Somnambulist\Components\Models\Types\Measure\Area', 'Somnambulist\Components\Domain\Entities\Types\Measure\Area');
class_alias('Somnambulist\Components\Models\Types\Measure\AreaUnit', 'Somnambulist\Components\Domain\Entities\Types\Measure\AreaUnit');
class_alias('Somnambulist\Components\Models\Types\Measure\Distance', 'Somnambulist\Components\Domain\Entities\Types\Measure\Distance');
class_alias('Somnambulist\Components\Models\Types\Measure\DistanceUnit', 'Somnambulist\Components\Domain\Entities\Types\Measure\DistanceUnit');
class_alias('Somnambulist\Components\Models\Types\Money\Currency', 'Somnambulist\Components\Domain\Entities\Types\Money\Currency');
class_alias('Somnambulist\Components\Models\Types\Money\Money', 'Somnambulist\Components\Domain\Entities\Types\Money\Money');
class_alias('Somnambulist\Components\Models\Types\PhoneNumber', 'Somnambulist\Components\Domain\Entities\Types\PhoneNumber');
class_alias('Somnambulist\Components\Models\Types\Web\IPV6Address', 'Somnambulist\Components\Domain\Entities\Types\Web\IPV6Address');
class_alias('Somnambulist\Components\Models\Types\Web\IPV4Address', 'Somnambulist\Components\Domain\Entities\Types\Web\IPv4Address');
class_alias('Somnambulist\Components\Models\Types\Web\IpAddress', 'Somnambulist\Components\Domain\Entities\Types\Web\IpAddress');
class_alias('Somnambulist\Components\Models\Types\Web\Url', 'Somnambulist\Components\Domain\Entities\Types\Web\Url');
class_alias('Somnambulist\Components\Events\AbstractEvent', 'Somnambulist\Components\Domain\Events\AbstractEvent');
class_alias('Somnambulist\Components\Events\Adapters\DomainEventNormalizer', 'Somnambulist\Components\Domain\Events\Adapters\DomainEventNormalizer');
class_alias('Somnambulist\Components\Events\Adapters\MessengerEventBus', 'Somnambulist\Components\Domain\Events\Adapters\MessengerEventBus');
class_alias('Somnambulist\Components\Events\Adapters\MessengerSerializer', 'Somnambulist\Components\Domain\Events\Adapters\MessengerSerializer');
class_alias('Somnambulist\Components\Events\Behaviours\CanDecorateEvents', 'Somnambulist\Components\Domain\Events\Behaviours\CanDecorateEvents');
class_alias('Somnambulist\Components\Events\Behaviours\CanGatherEventsForDispatch', 'Somnambulist\Components\Domain\Events\Behaviours\CanGatherEventsForDispatch');
class_alias('Somnambulist\Components\Events\Behaviours\CanSortEvents', 'Somnambulist\Components\Domain\Events\Behaviours\CanSortEvents');
class_alias('Somnambulist\Components\Events\Decorators\DecorateWithRequestId', 'Somnambulist\Components\Domain\Events\Decorators\DecorateWithRequestId');
class_alias('Somnambulist\Components\Events\Decorators\DecorateWithUserData', 'Somnambulist\Components\Domain\Events\Decorators\DecorateWithUserData');
class_alias('Somnambulist\Components\Events\EventBus', 'Somnambulist\Components\Domain\Events\EventBus');
class_alias('Somnambulist\Components\Events\EventDecoratorInterface', 'Somnambulist\Components\Domain\Events\EventDecoratorInterface');
class_alias('Somnambulist\Components\Events\Publishers\AbstractEventPublisher', 'Somnambulist\Components\Domain\Events\Publishers\AbstractEventPublisher');
class_alias('Somnambulist\Components\Events\Publishers\DoctrineEventPublisher', 'Somnambulist\Components\Domain\Events\Publishers\DoctrineEventPublisher');
class_alias('Somnambulist\Components\Events\Publishers\MessengerEventPublisher', 'Somnambulist\Components\Domain\Events\Publishers\MessengerEventPublisher');
class_alias('Somnambulist\Components\Jobs\AbstractJob', 'Somnambulist\Components\Domain\Jobs\AbstractJob');
class_alias('Somnambulist\Components\Jobs\Adapters\MessengerJobQueue', 'Somnambulist\Components\Domain\Jobs\Adapters\MessengerJobQueue');
class_alias('Somnambulist\Components\Jobs\JobQueue', 'Somnambulist\Components\Domain\Jobs\JobQueue');
class_alias('Somnambulist\Components\Queries\AbstractFindByIdQuery', 'Somnambulist\Components\Domain\Queries\AbstractFindByIdQuery');
class_alias('Somnambulist\Components\Queries\AbstractPaginatableQuery', 'Somnambulist\Components\Domain\Queries\AbstractPaginatableQuery');
class_alias('Somnambulist\Components\Queries\AbstractQuery', 'Somnambulist\Components\Domain\Queries\AbstractQuery');
class_alias('Somnambulist\Components\Queries\Adapters\MessengerQueryBus', 'Somnambulist\Components\Domain\Queries\Adapters\MessengerQueryBus');
class_alias('Somnambulist\Components\Queries\Behaviours\CanConvertValueToBoolean', 'Somnambulist\Components\Domain\Queries\Behaviours\CanConvertValueToBoolean');
class_alias('Somnambulist\Components\Queries\Behaviours\CanIncludeRelatedData', 'Somnambulist\Components\Domain\Queries\Behaviours\CanIncludeRelatedData');
class_alias('Somnambulist\Components\Queries\Behaviours\CanPaginateQuery', 'Somnambulist\Components\Domain\Queries\Behaviours\CanPaginateQuery');
class_alias('Somnambulist\Components\Queries\Behaviours\CanSortQuery', 'Somnambulist\Components\Domain\Queries\Behaviours\CanSortQuery');
class_alias('Somnambulist\Components\Queries\QueryBus', 'Somnambulist\Components\Domain\Queries\QueryBus');
class_alias('Somnambulist\Components\Utils\EntityAccessor', 'Somnambulist\Components\Domain\Utils\EntityAccessor');
class_alias('Somnambulist\Components\Utils\IdentityGenerator', 'Somnambulist\Components\Domain\Utils\IdentityGenerator');
class_alias('Somnambulist\Components\Utils\ObjectDiff', 'Somnambulist\Components\Domain\Utils\ObjectDiff');
class_alias('Somnambulist\Components\Utils\Tests\Assertions\AssertDoesNotHaveDomainEventOfType', 'Somnambulist\Components\Domain\Utils\Tests\Assertions\AssertDoesNotHaveDomainEventOfType');
class_alias('Somnambulist\Components\Utils\Tests\Assertions\AssertDomainEventHasAttributes', 'Somnambulist\Components\Domain\Utils\Tests\Assertions\AssertDomainEventHasAttributes');
class_alias('Somnambulist\Components\Utils\Tests\Assertions\AssertEntityHasPropertyWithValue', 'Somnambulist\Components\Domain\Utils\Tests\Assertions\AssertEntityHasPropertyWithValue');
class_alias('Somnambulist\Components\Utils\Tests\Assertions\AssertHasDomainEventOfType', 'Somnambulist\Components\Domain\Utils\Tests\Assertions\AssertHasDomainEventOfType');