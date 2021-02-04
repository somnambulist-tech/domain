## Doctrine Enum Bridge

Provides a bridge between different enumeration implementations and Doctrine. Any type of PHP
enumerable (e.g. Eloquent\Enumeration or myclabs/php-enum can be used with this adaptor.

A default, string casting, serializer is used if no serializer is provided.

All enumerations are stored using the DBs native varchar format. If you wish to use a custom
DB type, extend and re-implement the `getSQLDeclaration()` method.

### Usage

In your frameworks application service provider / bundle boot method, register your enums and
the appropriate callables to create / serialize as needed. A default serializer that casts the
enumerable to a string will be used if none is provided.

The callbacks will receive:

 * value    - the current value either a PHP type, or the database type (for constructor)
 * platform - the Doctrine AbstractPlatform instance

For example, in a Symfony project, in your AppBundle class:

```php
<?php
use Somnambulist\Components\Domain\Doctrine\Types\EnumerationBridge;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    public function boot()
    {
        EnumerationBridge::registerEnumType(Action::class, function ($value) {
            if (Action::isValid($value)) {
                return new Action($value);
            }

            throw new InvalidArgumentException(sprintf(
                'The value "%s" is not valid for the enum "%s". Expected one of ["%s"]',
                $value,
                Action::class,
                implode('", "', Action::toArray())
            ));
        });
    }
}
```
    
In Laravel, add to your AppServiceProvider (`register` and `boot` should both work):

```php
<?php
use Somnambulist\Components\Domain\Doctrine\Types\EnumerationBridge;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        EnumerationBridge::registerEnumType(Action::class, function ($value) {
            if (Action::isValid($value)) {
                return new Action($value);
            }

            throw new InvalidArgumentException(sprintf(
                'The value "%s" is not valid for the enum "%s". Expected one of ["%s"]',
                $value,
                Action::class,
                implode('", "', Action::toArray())
            ));
        });
    }
}
```

When registering the type, you can either use the fully qualified class name, or an alias / short
string. The only limitation is that it should be unique for each enumeration. In the above example
we could register the enumeration as `http_action` instead.

__Note:__ the bridge will check if the type has already been registered and skip it if that is
the case. If you wish to replace an existing type then you should use `Type::overrideType()`,
however that will only work if the type has already been registered.

__Note:__ when using short aliases you **MUST** explicitly set the class in the constructor for
hydrating the object. This means that constructors cannot be shared with other types.

#### Register Multiple Types

Multiple enumerations can be registered at once by calling `registerEnumTypes()` and passing an
array of enum name and either an array of callables (constructor, serializer) or just the 
constructor:

```php
<?php
use Somnambulist\Components\Domain\Doctrine\Types\EnumerationBridge;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    public function boot()
    {
        EnumerationBridge::registerEnumTypes(
            [
                'gender' => [
                    function ($value) {
                        if (Gender::isValidValue($value)) {
                            return Gender::memberByValue($value);
                        }
            
                        throw new InvalidArgumentException(sprintf(
                            'The value "%s" is not valid for the enum "%s"', $value, Gender::class
                        ));
                    },
                    function ($value, $platform) {
                        return is_null($value) ? 'default' : $value->value();
                    }
                ]
            ]
        );
    }
}
```

#### Usage in Doctrine Mapping Files

In your Doctrine mapping files simply set the type on the field:

```yaml
fields:
    name:
        type: string
        length: 255
    
    gender:
        type: gender
    
    action:
        type: AppBundle\Enumerable\Action
```

The type should be set to whatever you used when registering. If this is the class name, use that;
if you used a short name - use that instead. It is recommended to use short names as it is easier
to manage them than figuring out the full class name (that does not usually auto-complete).

__Note__: Doctrine has deprecated Yaml config, use XML instead.

### Built-in Enumeration Constructors

The following value-object constructors are provided in the library in the `Doctrine\Enumerations`
namespace:

 * CountryEnumeration
 * CurrencyEnumeration
 * GenericEloquentEnumeration
 * GenericEloquentMultiton
 * NullableGenericEloquentEnumeration
 
When using Country or Currency the custom serializer should be registered to correctly convert the
VO to the ISO code for storage. These would be setup as follows:

```php
<?php
use Somnambulist\Components\Domain\Doctrine\Enumerations\Constructors\CountryConstructor;
use Somnambulist\Components\Domain\Doctrine\Enumerations\Constructors\CurrencyConstructor;
use Somnambulist\Components\Domain\Doctrine\Enumerations\Serializers\CountrySerializer;
use Somnambulist\Components\Domain\Doctrine\Enumerations\Serializers\CurrencySerializer;
use Somnambulist\Components\Domain\Doctrine\Types\EnumerationBridge;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    public function boot()
    {
        EnumerationBridge::registerEnumType('country', new CountryConstructor(), new CountrySerializer());
        EnumerationBridge::registerEnumType('currency', new CurrencyConstructor(), new CurrencySerializer());
    }
}
```

__Note:__ the first argument of `registerEnumType` is the alias/name for how to refer to this type.
If you use the fully qualified class name via the `::class` constant, then the Doctrine mapping must
reference this type:

```xml
<field name="currency" type="Somnambulist\Components\Domain\Entities\Types\Money\Currency" length="3" nullable="false"/>
```
vs:
```xml
<field name="currency" type="currency" length="3" nullable="false"/>
```

By default short aliases are registered by this library.

### Links

 * [Doctrine](http://doctrine-project.org)
 * [Doctrine Enum Type](https://github.com/acelaya/doctrine-enum-type)
 * [Eloquent Enumeration](https://github.com/eloquent/enumeration)
 * [PHP-Enum](https://github.com/myclabs/php-enum)
