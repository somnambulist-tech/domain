## Doctrine Mappings for Value Objects and Enumerations

Provides a basic set of mapping information for the somnambulist/value-objects library for
use with Doctrine. Mappings are available for Doctrine (.dcm.yml) and Symfony (.orm.yml).
The mappings are symlinked from symfony to doctrine.

A `TypeBootstrapper` is included for automatically registering the value-object enumerations
as Doctrine types.

### Requirements

 * PHP 7.4+
 * Doctrine ORM 2.7+

### Usage

Copy or link the mapping files to your project in the Doctrine configuration. These are
needed per entity manager. It is highly recommended to extend the value-objects to your
own and then copy and adapt the mappings as you need.

Remember: value-objects are part of your domain model and should be treated with care.

__Note:__ enumerations are used in these mappings.

#### Register Enumeration Handlers

To register the enumeration handlers add the following to your applications bootstrap
code (e.g.: AppBundle::boot or AppServiceProvider::register|boot):

    Somnambulist\Domain\Doctrine\TypeBootstrapper::registerEnumerations();

This will pre-register the following enumerations:

 * Geography\Country as country
 * Money\Currency as currency
 * Measure\AreaUnit as area_unit
 * Measure\DistanceUnit as distance_unit
 * Geography\Srid as srid
 
In addition extra helpers are registered to allow the Country and Currency value objects
to be used as enumerations. These are stored using the respective ISO 3-char codes.

__Note:__ concrete enumerations cannot be extended. If the built in ones do not meet your
needs, create your own.

See [Doctrine Enumeration Bridge](./doctrine-enum-bridge.md) for more on using the bridge.

#### Register Custom Types

Custom types are included for:

 * datetime
 * datetimetz
 * date
 * time
 * json
 * ip_v4_address
 * ip_v6_address
 * email
 * phone
 * url
 * uuid

The date types override the default Doctrine types and uses the VO DateTime that is an
extended DateTimeImmutable object.

json, jsonb and json_collection are equivalent and allow JSON data to be converted to and
from a Collection object instead of a plain array.

To register all the standard types add the following to your application bootstrap:

    Somnambulist\Domain\Doctrine\TypeBootstrapper::registerTypes(TypeBootstrapper::$types);

__Note:__ if you register `uuid` as a type, and then use it in e.g.: an embeddable your
embeddable with receive a Uuid object, not a Uuid string. Ensure the type is set to `guid`
to get just the string value.

#### Mapping Files

To use the types and enumerations, in your mapping files set the type appropriately:

```yaml
fields:
    createdAt:
        type: datetime
    
    attributes:
        type: json

    country:
        type: country
    
    currency:
        type: currency
```

To embedded the value-objects instead of using type casting:

```yaml
embedded:
    contact:
        class: Somnambulist\Domain\Entities\Types\Identity\EmailAddress
        
    homepage:
        class: Somnambulist\Domain\Entities\Types\Web\Url
```

Or in XML format:

```xml
<entity name="My\Entity">
    <embedded name="contact" class="Somnambulist\Domain\Entities\Types\Identity\EmailAddress" />
    <embedded name="homepage" class="Somnambulist\Domain\Entities\Types\Web\Url" />
</entity>
```

When using embeddables, be sure to have added the necessary mapping files.

Alternatively if the extended types are registered you can instead use:

```xml
<entity name="My\Entity">
    <field name="email" class="email" length="200" />
    <field name="phone" class="phone" length="20" />
    <field name="homepage" class="url" length="400" />
</entity>
```

The primary difference is that the type can be customised per column, whereas an embedded
object is shared with a common config and therefore, fixed length or nullable or not.

### Configuring Types for Symfony

Within a Symfony project, add a new mapping area to your orm configuration within the `doctrine` section:

```yaml
doctrine:
    # snip ...
    orm:
        mappings:
            App\Entities:
                mapping:   true
                type:      xml
                dir:       '%kernel.project_dir%/config/mappings/entities'
                is_bundle: false
                prefix:    App\Entities

            Somnambulist\Domain\Entities\Types:
                mapping:   true
                type:      xml
                dir:       '%kernel.project_dir%/config/mappings/somnambulist'
                is_bundle: false
                prefix:    Somnambulist\Domain\Entities\Types
```

Then either copy or symlink the appropriate config files from vendor config folder to your projects
mapping config section. If you have different requirements for field type, copy and update as appropriate.
It is recommended to copy and not link the mapping files to avoid issues with this library changing.

### Links

 * [Doctrine](http://doctrine-project.org)
 * [Enumeration Bridge](doctrine-enum-bridge.md)
 * [Value Objects](value-objects.md)
