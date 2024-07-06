<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\TypeRegistry;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use ReflectionProperty;
use Somnambulist\Components\Doctrine\Types\EnumerationBridge;
use Somnambulist\Components\Tests\Support\Stubs\Enum\Action;
use Somnambulist\Components\Tests\Support\Stubs\Enum\Gender;
use Somnambulist\Components\Tests\Support\Stubs\Enum\NullableType;
use Somnambulist\Components\Tests\Support\Stubs\Helpers\Constructor;
use Somnambulist\Components\Tests\Support\Stubs\Helpers\NullableConstructor;
use Somnambulist\Components\Tests\Support\Stubs\Helpers\Serializer;
use Somnambulist\Components\Tests\Support\Stubs\Types\MyType;
use Somnambulist\Components\Utils\EntityAccessor;

#[Group('doctrine')]
#[Group('doctrine-behaviours')]
#[Group('doctrine-behaviours-enum')]
class EnumerationBridgeTest extends TestCase
{
    use ProphecyTrait;

    protected mixed $platform = null;

    public function setUp(): void
    {
        $this->platform = $this->prophesize(AbstractPlatform::class);

        // Before every test, clean registered types
        EntityAccessor::set(Type::getTypeRegistry(), 'instances', [], TypeRegistry::class);
        EntityAccessor::set(Type::getTypeRegistry(), 'instancesReverseIndex', [], TypeRegistry::class);
    }

    public function tearDown(): void
    {
        $refProp = new ReflectionProperty(Type::class, 'typeRegistry');
        $refProp->setAccessible(true);
        $refProp->setValue(null, null);
    }

    public function testEnumTypesAreProperlyRegistered()
    {
        $this->assertFalse(Type::hasType(Action::class));
        $this->assertFalse(Type::hasType('gender'));

        EnumerationBridge::registerEnumType(Action::class, function ($value) {
            if (Action::hasValue($value)) {
                return Action::memberByValue($value);
            }

            throw new InvalidArgumentException(sprintf('"%s" not valid for "%s"', $value, Action::class));
        });
        EnumerationBridge::registerEnumTypes([
            'gender' => function ($value) {
                if (null !== $gender = Gender::memberOrNullByValue($value)) {
                    return $gender;
                }

                throw new InvalidArgumentException(sprintf('"%s" not valid for "%s"', $value, Gender::class));
            },
        ]);

        $this->assertTrue(Type::hasType(Action::class));
        $this->assertTrue(Type::hasType('gender'));
    }

    public function testEnumTypesAreProperlyCustomizedWhenRegistered()
    {
        $this->assertFalse(Type::hasType(Action::class));
        $this->assertFalse(Type::hasType(Gender::class));

        EnumerationBridge::registerEnumTypes([
            Action::class => function ($value) {
                if (Action::hasValue($value)) {
                    return Action::memberByValue($value);
                }

                throw new InvalidArgumentException(sprintf('"%s" not valid for "%s"', $value, Action::class));
            },
            'gender' => function ($value) {
                if (null !== $gender = Gender::memberOrNullByValue($value)) {
                    return $gender;
                }

                throw new InvalidArgumentException(sprintf('"%s" not valid for "%s"', $value, Gender::class));
            },
        ]);

        $actionType = Type::getType(Action::class);
        $this->assertInstanceOf(EnumerationBridge::class, $actionType);
        $this->assertEquals(Action::class, $actionType->getName());

        $genderType = Type::getType('gender');
        $this->assertInstanceOf(EnumerationBridge::class, $genderType);
        $this->assertEquals('gender', $genderType->getName());
    }

    public function testCanAssignInvokableObjectInstances()
    {
        $this->assertFalse(Type::hasType(Action::class));
        $this->assertFalse(Type::hasType(Gender::class));

        EnumerationBridge::registerEnumTypes([
            Action::class => function ($value) {
                if (Action::hasValue($value)) {
                    return Action::memberByValue($value);
                }

                throw new InvalidArgumentException(sprintf('"%s" not valid for "%s"', $value, Action::class));
            },
            'gender' => [new Constructor(), new Serializer()],
            'gender2' => new Constructor(),
        ]);

        $actionType = Type::getType(Action::class);
        $this->assertInstanceOf(EnumerationBridge::class, $actionType);
        $this->assertEquals(Action::class, $actionType->getName());

        $genderType = Type::getType('gender');
        $this->assertInstanceOf(EnumerationBridge::class, $genderType);
        $this->assertEquals('gender', $genderType->getName());
    }

    public function testGetSQLDeclarationReturnsValueFromPlatform()
    {
        $this->platform->getStringTypeDeclarationSQL(Argument::cetera())->willReturn('declaration');

        EnumerationBridge::registerEnumType(Gender::class, function ($value) {
            if (null !== $gender = Gender::memberOrNullByValue($value)) {
                return $gender;
            }

            throw new InvalidArgumentException(sprintf('"%s" not valid for "%s"', $value, Gender::class));
        });

        $type = Type::getType(Gender::class);
        $this->assertEquals('declaration', $type->getSQLDeclaration([], $this->platform->reveal()));
    }

    public function testConvertToDatabaseValueParsesEnum()
    {
        EnumerationBridge::registerEnumType(Action::class, function ($value) {
            if (Action::hasValue($value)) {
                return Action::memberByValue($value);
            }

            throw new InvalidArgumentException(sprintf('"%s" not valid for "%s"', $value, Action::class));
        });

        $type  = Type::getType(Action::class);

        $value = Action::CREATE();
        $this->assertEquals(Action::CREATE, $type->convertToDatabaseValue($value, $this->platform->reveal()));

        $value = Action::READ();
        $this->assertEquals(Action::READ, $type->convertToDatabaseValue($value, $this->platform->reveal()));

        $value = Action::UPDATE();
        $this->assertEquals(Action::UPDATE, $type->convertToDatabaseValue($value, $this->platform->reveal()));

        $value = Action::DELETE();
        $this->assertEquals(Action::DELETE, $type->convertToDatabaseValue($value, $this->platform->reveal()));
    }

    public function testConvertToPHPValueWithValidValueReturnsParsedData()
    {
        EnumerationBridge::registerEnumType(Action::class, function ($value) {
            if (Action::hasValue($value)) {
                return Action::memberByValue($value);
            }

            throw new InvalidArgumentException(sprintf('"%s" not valid for "%s"', $value, Action::class));
        });

        $type = Type::getType(Action::class);

        /** @var Action $value */
        $value = $type->convertToPHPValue(Action::CREATE, $this->platform->reveal());
        $this->assertInstanceOf(Action::class, $value);
        $this->assertEquals(Action::CREATE, $value->value());

        $value = $type->convertToPHPValue(Action::DELETE, $this->platform->reveal());
        $this->assertInstanceOf(Action::class, $value);
        $this->assertEquals(Action::DELETE, $value->value());
    }

    public function testConvertToPHPValueWithNullReturnsNull()
    {
        EnumerationBridge::registerEnumType(Action::class, new Constructor());

        $type = Type::getType(Action::class);
        $value = $type->convertToPHPValue(null, $this->platform->reveal());
        $this->assertNull($value);
    }

    public function testConvertToPHPValueWithNullValuesSupported()
    {
        EnumerationBridge::registerEnumType(NullableType::class, new NullableConstructor());

        $type = Type::getType(NullableType::class);

        /** @var NullableType $value */
        $value = $type->convertToPHPValue(null, $this->platform->reveal());

        $this->assertInstanceOf(NullableType::class, $value);
        $this->assertNull($value->value());
    }

    public function testConvertToPHPValueWithInvalidValueThrowsException()
    {
        EnumerationBridge::registerEnumType(Action::class, function ($value) {
            if (Action::hasValue($value)) {
                return Action::memberByValue($value);
            }

            throw new InvalidArgumentException(sprintf('"%s" not valid for "%s"', $value, Action::class));
        });

        $type = Type::getType(Action::class);
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('"%s" not valid for "%s"', 'invalid', Action::class));
        $type->convertToPHPValue('invalid', $this->platform->reveal());
    }

    public function testUsingChildEnumTypeRegisteredValueIsCorrect()
    {
        MyType::registerEnumType(Action::class, function ($value) {
            if (Action::hasValue($value)) {
                return Action::memberByValue($value);
            }

            throw new InvalidArgumentException(sprintf('"%s" not valid for "%s"', $value, Action::class));
        });

        $type = Type::getType(Action::class);
        $this->assertInstanceOf(MyType::class, $type);
        $this->assertEquals('FOO BAR', $type->getSQLDeclaration([], $this->platform->reveal()));
    }
}
