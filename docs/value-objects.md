## Value Objects Library

Value Objects (VOs) are immutable domain objects that represent some value in your domain model but without
a thread of continuous identity i.e. their identity is through their properties. VOs allow your entities to
encapsulate properties and provide type safety.

This library provides an abstract base class that provides a basic equality test and foundation for your
VOs along with a couple of basic types. As VOs form part of YOUR domain, you should implement the VOs that
you need for your domain, following your domain naming (e.g. if you do not call an email address an
EmailAddress then create your own VO for that purpose).

VOs should be self-validating during construction. For this purpose, the Assertion library by Benjamin
Eberlei is used, however you may wish to use another or filter_var() etc. directly.

If you see something missing or have suggestions for other methods, submit a PR or ticket.

### Usage

Extend the abstract value object and implement the single required method toString(). The default equality
method (equals()) uses reflection on the VO properties and compares them directly - only between VO types.

For example:

```php
<?php
use Assert\Assert;
use Somnambulist\Components\Models\AbstractValueObject;

final class Uuid extends AbstractValueObject
{
    private string $uuid;

    public function __construct(string $uuid)
    {
        Assert::that($uuid, null, 'uuid')->notEmpty()->uuid();

        $this->uuid = $uuid;
    }

    public function toString(): string
    {
        return $this->uuid;
    }
}

$uuid = new Uuid(\Ramsey\Uuid\Uuid::uuid4());
```

#### Usage with Doctrine

These VOs may be used with Doctrine as Embeddable objects - however if you allow the VO to be null, it will
be instantiated empty so your methods / toString() should handle that case e.g.:

A User has a nullable Profile VO, when Doctrine hydrates the User, the Profile VO will also be hydrated but
empty, so if the Profile has a nickname() or avatar() method, these must support returning null and your
toString() method must cast null to a string to avoid type errors.

__Note:__ when referencing UUIDs if the UUID type is registered and your field type is set to `uuid` Doctrine
will hydrate a Uuid object - not a string. Be sure to use `guid` as the type in these cases; or do not register
the UUID type mapping, or map that to something else.

### Provided Types

The following generics are provided as part of the `somnambulist/domain` library:

| Type Class                 | Description                                                                                       |
|----------------------------|---------------------------------------------------------------------------------------------------|
| Auth\Password              | A hashed password, validation is via the `password_get_info` function                             |
| Auth\PublicPrivateKey      | A key pair for HMAC signing / validation or other encryption tasks                                |
| DateTime\DateTime          | Extended `DateTimeImmutable` object with additional helpers                                       |
| DateTime\DateFormat        | All date formatting options as constants for reference                                            |
| DateTime\DateFormatBuilder | Aids building a date format through a fluent, descriptive interface                               |
| DateTime\TimeZone          | Extended `TimeZone` for DateTime component                                                        |
| Geography\Coordinate       | A latitude / longitude in a specific spatial system                                               |
| Geography\Country          | An enumerated ISO country object with 2/3/numeric codes                                           |
| Geography\Srid             | An enumerated spatial system reference number, only a couple are listed                           |
| Identity\AbstractIdentity  | A base class for validating a UUID as an identity, can be extended to named identity classes      |
| Identity\Aggregate         | The class name + id for an aggregate root                                                         |
| Identity\EmailAddress      | A valid email address                                                                             |
| Identity\ExternalIdentity  | An identity provided by a third party service                                                     |
| Identity\Id                | A generic identity object that is a UUID                                                          |
| Identity\Uuid              | A generic named UUID identity object                                                              |
| Measure\Area               | An area including the units describing that area                                                  |
| Measure\AreaUnit           | An enumeration of various area measurement types                                                  |
| Measure\Distance           | A distance including the units describing the distance                                            |
| Measure\DistanceUnit       | An enumeration of various distance measurement types                                              |
| Money\Currency             | An enumeration of various ISO currencies including the number of decimal places                   |
| Money\Money                | Represents an amount of money, not intended to be used for calculations                           |
| Web\IpAddress              | An abstract base class representing an IP address allowing either V4 or V6 to be used             |
| Web\IpV4Address            | An IPV4 address                                                                                   |
| Web\IpV6Address            | An IPV6 address                                                                                   |
| Web\Url                    | A valid URL, includes helper methods for extracting parts of the URL                              |
| AbstractType               | An abstract type allowing for user provided types instead of an enumeration                       |
| PhoneNumber                | A valid E164 phone number, this is a fully qualified +XXYYYY where XX is the country dialing code |

For the enumerations, additional values can be suggested by creating issues, or making a PR with the suggestions.

Note: for SRID values, there are thousands of potential systems - however many are geographic specific.
