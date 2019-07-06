## Enumerations

Enumerations are provided via the eloquent/enumeration library (not be confused with Laravel Eloquent).
An enumeration is essentially a typed constant where there is only every one instance of that value.

For example: HTTP verbs could be represented as an enumeration because there is never more than one
instance of GET, POST, PUT, PATCH, DELETE, HEAD etc.

The most useful feature of an enumeration is that it can only be one of the values that are defined
so now what would have been a string can be type hinted with a specific type.

### Usage

Continuing with the above example of HTTP verb, we create an enumeration as follow:

```php
namespace App\Domain;

final class HTTPMethod extends AbstractEnumeration
{
    const GET = 'GET';
    const POST = 'POST';
    const PATCH = 'PATCH';
    const PUT = 'PUT';
    const DELETE = 'DELETE';
    const HEAD = 'HEAD';
}
```
And then to use it:

```php
$verb = HTTPMethod::GET();
```
Each constant is converted to a method via __callStatic map throughs. It can be type-hinted on
a class e.g.:

```php
class RequestLog
{
    public function __construct(string $resource, HTTPMethod $method)
    {
    
    }
}
```

### Multitons

Enumerations are a simple type of multiton. A multiton is more or less the same thing, but can
have many properties. The example from the library is a `Planet` but you can consider Countries,
or Currencies as multitons. In fact that is how they are handled in this library.

An important difference between the multiton and the enumeration, is that we must define and
pre-load any of the instances by overloading: `initializeMembers`. Then in that method we create
our instances:

```php
final class Planet extends AbstractMultiton
{
    protected function __construct($key, $name, $diameter, $mass, $distanceToSun)
    {
        $this->name = $name;
        $this->diamemter = $diameter;
        $this->mass = $mass;
        $this->distanceToSun = $distanceToSun;
        
        // very important! be sure to pass the unique key to the parent constructor
        parent::__construct($key);
    }

    protected static function initializeMembers()
    {
        new static($key, $name, $diameter, $mass, $distanceToSun);
    }
}
```

Additionally: as a multiton can have many properties, we must define which one should be used
when casting to string:

```php
final class Planet extends AbstractMultiton
{

    public function toString(): string
    {
        return (string)$this->name();
    }
}
```

The planet can then be accessed using: `Planet::memberByKey('<the name>');`

__Important:__ once created an enumeration / multiton CANNOT be extended! So always mark them
as `final`.

Checkout the Currency and Country objects for examples of multitons.

See [Doctrine Enum Bridge](doctrine-enum-bridge.md) for how to integrate enumerations with Doctrine.
