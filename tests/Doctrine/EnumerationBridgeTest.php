<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Doctrine\DoctrineEnumBridge;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ArrayType;
use Doctrine\DBAL\Types\BigIntType;
use Doctrine\DBAL\Types\BinaryType;
use Doctrine\DBAL\Types\BlobType;
use Doctrine\DBAL\Types\BooleanType;
use Doctrine\DBAL\Types\DateImmutableType;
use Doctrine\DBAL\Types\DateIntervalType;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\DBAL\Types\DateTimeTzImmutableType;
use Doctrine\DBAL\Types\DateTimeTzType;
use Doctrine\DBAL\Types\DateType;
use Doctrine\DBAL\Types\DecimalType;
use Doctrine\DBAL\Types\FloatType;
use Doctrine\DBAL\Types\GuidType;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\JsonType;
use Doctrine\DBAL\Types\ObjectType;
use Doctrine\DBAL\Types\SimpleArrayType;
use Doctrine\DBAL\Types\SmallIntType;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\TextType;
use Doctrine\DBAL\Types\TimeImmutableType;
use Doctrine\DBAL\Types\TimeType;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Somnambulist\Domain\Doctrine\EnumerationBridge;
use Somnambulist\Domain\Tests\Doctrine\Enum\Action;
use Somnambulist\Domain\Tests\Doctrine\Enum\Gender;
use Somnambulist\Domain\Tests\Doctrine\Enum\NullableType;
use Somnambulist\Domain\Tests\Doctrine\Helpers\Constructor;
use Somnambulist\Domain\Tests\Doctrine\Helpers\NullableConstructor;
use Somnambulist\Domain\Tests\Doctrine\Helpers\Serializer;
use Somnambulist\Domain\Tests\Doctrine\MyType;

/**
 * Class EnumerationBridgeTest
 *
 * Tests adapted from:
 * https://github.com/acelaya/doctrine-enum-type/blob/master/tests/Type/PhpEnumTypeTest.php
 *
 * @package    Somnambulist\Domain\Tests\Doctrine
 * @subpackage Somnambulist\Domain\Tests\Doctrine\EnumerationBridgeTest
 * @group enum-bridge
 */
class EnumerationBridgeTest extends TestCase
{
    /**
     * @var AbstractPlatform
     */
    protected $platform;

    public function setUp(): void
    {
        $this->platform = $this->prophesize(AbstractPlatform::class);

        // Before every test, clean registered types
        $registry = new \ReflectionObject(Type::getTypeRegistry());
        $refProp = $registry->getProperty('instances');
        $refProp->setAccessible(true);
        $refProp->setValue($registry, []);
    }

    public function tearDown(): void
    {
        $refProp = new \ReflectionProperty(Type::class, 'typeRegistry');
        $refProp->setAccessible(true);
        $refProp->setValue(null);
    }

    /**
     * @test
     */
    public function enumTypesAreProperlyRegistered()
    {
        $this->assertFalse(Type::hasType(Action::class));
        $this->assertFalse(Type::hasType('gender'));

        EnumerationBridge::registerEnumType(Action::class, function ($value) {
            if (Action::isValid($value)) {
                return new Action($value);
            }

            throw new \InvalidArgumentException(sprintf('"%s" not valid for "%s"', $value, Action::class));
        });
        EnumerationBridge::registerEnumTypes([
            'gender' => function ($value) {
                if (null !== $gender = Gender::memberOrNullByValue($value)) {
                    return $gender;
                }

                throw new \InvalidArgumentException(sprintf('"%s" not valid for "%s"', $value, Gender::class));
            },
        ]);

        $this->assertTrue(Type::hasType(Action::class));
        $this->assertTrue(Type::hasType('gender'));
    }

    /**
     * @test
     */
    public function enumTypesAreProperlyCustomizedWhenRegistered()
    {
        $this->assertFalse(Type::hasType(Action::class));
        $this->assertFalse(Type::hasType(Gender::class));

        EnumerationBridge::registerEnumTypes([
            Action::class => function ($value) {
                if (Action::isValid($value)) {
                    return new Action($value);
                }

                throw new \InvalidArgumentException(sprintf('"%s" not valid for "%s"', $value, Action::class));
            },
            'gender' => function ($value) {
                if (null !== $gender = Gender::memberOrNullByValue($value)) {
                    return $gender;
                }

                throw new \InvalidArgumentException(sprintf('"%s" not valid for "%s"', $value, Gender::class));
            },
        ]);

        /** @var Type $actionType */
        $actionType = Type::getType(Action::class);
        $this->assertInstanceOf(EnumerationBridge::class, $actionType);
        $this->assertEquals(Action::class, $actionType->getName());

        /** @var Type $actionType */
        $genderType = Type::getType('gender');
        $this->assertInstanceOf(EnumerationBridge::class, $genderType);
        $this->assertEquals('gender', $genderType->getName());
    }

    /**
     * @test
     */
    public function canAssignInvokableObjectInstances()
    {
        $this->assertFalse(Type::hasType(Action::class));
        $this->assertFalse(Type::hasType(Gender::class));

        EnumerationBridge::registerEnumTypes([
            Action::class => function ($value) {
                if (Action::isValid($value)) {
                    return new Action($value);
                }

                throw new \InvalidArgumentException(sprintf('"%s" not valid for "%s"', $value, Action::class));
            },
            'gender' => [new Constructor(), new Serializer()],
            'gender2' => new Constructor(),
        ]);

        /** @var Type $actionType */
        $actionType = Type::getType(Action::class);
        $this->assertInstanceOf(EnumerationBridge::class, $actionType);
        $this->assertEquals(Action::class, $actionType->getName());

        /** @var Type $actionType */
        $genderType = Type::getType('gender');
        $this->assertInstanceOf(EnumerationBridge::class, $genderType);
        $this->assertEquals('gender', $genderType->getName());
    }

    /**
     * @test
     */
    public function getSQLDeclarationReturnsValueFromPlatform()
    {
        $this->platform->getVarcharTypeDeclarationSQL(Argument::cetera())->willReturn('declaration');

        EnumerationBridge::registerEnumType(Gender::class, function ($value) {
            if (null !== $gender = Gender::memberOrNullByValue($value)) {
                return $gender;
            }

            throw new \InvalidArgumentException(sprintf('"%s" not valid for "%s"', $value, Gender::class));
        });

        $type = Type::getType(Gender::class);
        $this->assertEquals('declaration', $type->getSQLDeclaration([], $this->platform->reveal()));
    }

    /**
     * @test
     */
    public function convertToDatabaseValueParsesEnum()
    {
        EnumerationBridge::registerEnumType(Action::class, function ($value) {
            if (Action::isValid($value)) {
                return new Action($value);
            }

            throw new \InvalidArgumentException(sprintf('"%s" not valid for "%s"', $value, Action::class));
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

    /**
     * @test
     */
    public function convertToPHPValueWithValidValueReturnsParsedData()
    {
        EnumerationBridge::registerEnumType(Action::class, function ($value) {
            if (Action::isValid($value)) {
                return new Action($value);
            }

            throw new \InvalidArgumentException(sprintf('"%s" not valid for "%s"', $value, Action::class));
        });

        $type = Type::getType(Action::class);

        /** @var Action $value */
        $value = $type->convertToPHPValue(Action::CREATE, $this->platform->reveal());
        $this->assertInstanceOf(Action::class, $value);
        $this->assertEquals(Action::CREATE, $value->getValue());

        $value = $type->convertToPHPValue(Action::DELETE, $this->platform->reveal());
        $this->assertInstanceOf(Action::class, $value);
        $this->assertEquals(Action::DELETE, $value->getValue());
    }

    /**
     * @test
     */
    public function convertToPHPValueWithNullReturnsNull()
    {
        EnumerationBridge::registerEnumType(Action::class, new Constructor());

        $type = Type::getType(Action::class);
        $value = $type->convertToPHPValue(null, $this->platform->reveal());
        $this->assertNull($value);
    }

    /**
     * @test
     */
    public function convertToPHPValueWithNullValuesSupported()
    {
        EnumerationBridge::registerEnumType(NullableType::class, new NullableConstructor());

        $type = Type::getType(NullableType::class);

        /** @var NullableType $value */
        $value = $type->convertToPHPValue(null, $this->platform->reveal());

        $this->assertInstanceOf(NullableType::class, $value);
        $this->assertNull($value->value());
    }

    /**
     * @test
     */
    public function convertToPHPValueWithInvalidValueThrowsException()
    {
        EnumerationBridge::registerEnumType(Action::class, function ($value) {
            if (Action::isValid($value)) {
                return new Action($value);
            }

            throw new \InvalidArgumentException(sprintf('"%s" not valid for "%s"', $value, Action::class));
        });

        $type = Type::getType(Action::class);
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('"%s" not valid for "%s"', 'invalid', Action::class));
        $type->convertToPHPValue('invalid', $this->platform->reveal());
    }

    /**
     * @test
     */
    public function usingChildEnumTypeRegisteredValueIsCorrect()
    {
        MyType::registerEnumType(Action::class, function ($value) {
            if (Action::isValid($value)) {
                return new Action($value);
            }

            throw new \InvalidArgumentException(sprintf('"%s" not valid for "%s"', $value, Action::class));
        });

        $type = Type::getType(Action::class);
        $this->assertInstanceOf(MyType::class, $type);
        $this->assertEquals('FOO BAR', $type->getSQLDeclaration([], $this->platform->reveal()));
    }
}
