## Value Objects Library

Value Objects (VOs) are Immutable domain objects that represent some value in your domain model but without
a thread of continuous identity i.e. their identity is through their properties. VOs allow your entities to
encapsulate properties and provide type safety.

This library provides an abstract base class that provides a basic equality test and foundation for your
VOs along with a couple of basic types. As VOs form part of YOUR domain, you should implement the VOs that
you need for your domain, following your domain naming (e.g. if you do not call an email address an
EmailAddress then create your own VO for that purpose).

VOs should be self-validating during construction. For this purpose, the Assertion library by Benjamin
Eberlei is used, however you may wish to use another or filter_var() etc directly.

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
