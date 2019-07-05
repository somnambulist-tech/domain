## Doctrine Enum Bridge

Provides a bridge between different enumeration implementations and Doctrine. Any type of PHP
enumerable (e.g. Eloquent\Enumeration or myclabs/php-enum can be used with this adaptor.

A default, string casting, serializer is used if no serializer is provided.

All enumerations are stored using the DBs native varchar format. If you wish to use a custom
DB type, extend and re-implement the `getSQLDeclaration()` method.

### Requirements

 * PHP 7+
 * Doctrine 2.5+

### Usage

In your frameworks application service provider / bundle boot method, register your enums and
the appropriate callables to create / serialize as needed. A default serializer that casts the
enumerable to a string will be used if none is provided.

The callbacks will receive:

 * value    - the current value either a PHP type, or the database type (for constructor)
 * name     - the bound name given to the enumeration this could be the FQCN
 * platform - the Doctrine AbstractPlatform instance

For example, in a Symfony project, in your AppBundle class:

```php
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

__Note:__ the bridge will check if the type has already been registered and skip it if that is
the case. If you wish to replace an existing type then you should use `Type::overrideType()`,
however that will only work if the type has already been registered.

#### Register Multiple Types

Multiple enumerations can be registered at once by calling `registerEnumTypes()` and passing an
array of enum name and either an array of callables (constructor, serializer) or just the 
constructor:

```php
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

__Note__: Doctrine has deprecated Yaml config, use XML instead.

#### Share a Constructor

For enumerables that have the same signature / method names, a constructor callable can be shared.

To share a constructor callable, use the FQCN as the name of the enumerable or you could use a hash
map of aliases to Enumerables:

```php
class AppBundle extends Bundle
{
    public function boot()
    {
        $constructor = function ($value, $class) {
            // constructor method should handle nulls
            if (is_null($value)) {
                return null;
            }
        
            if ($class::isValid($value)) {
                return new $class($value);
            }
        
            throw new InvalidArgumentException(sprintf(
                'The value "%s" is not valid for the enum "%s". Expected one of ["%s"]',
                $value,
                $class,
                implode('", "', $class::toArray())
           ));
        }
    
        EnumerationBridge::registerEnumType(Action::class, $constructor);
        EnumerationBridge::registerEnumType(Country::class, $constructor);
        EnumerationBridge::registerEnumType(Currency::class, $constructor);
    }
}
```

Because each enumerable can be mapped to its own construct / serializer handlers, complex multitions
from the Eloquent\Enumerable library can be handled by this bridge.

### Links

 * [Doctrine](http://doctrine-project.org)
 * [Doctrine Enum Type](https://github.com/acelaya/doctrine-enum-type)
 * [Eloquent Enumeration](https://github.com/eloquent/enumeration)
 * [PHP-Enum](https://github.com/myclabs/php-enum)
