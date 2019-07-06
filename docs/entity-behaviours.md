## Entity Behaviours

Provides some useful interfaces and traits that can be used with entities. The traits implement on
basic methods, and still require e.g. publish/unpublish to be implemented.

### Behaviours

Unlike the somnambulist/laravel-doctrine-behaviours package, these behaviours are intended to be used in a
much more controlled and DDD based system. As such they do not implement setters and in some cases even
the methods defined in the interfaces as these are core domain methods that should raise events within
your system.

 1. Activatable
 
    Adds `activate()`/`deactivate()` methods to an entity controlling if it is active or not. The entity should
    implement activate/deactivate methods so that Events can be raised.
    
    Note: there is no trait as activate/deactivate are domain operations.

 1. Identifiable
 
    Adds an `id()` method that returns the primary identifier (int, string, object)
    
    Note: there is no trait as "id" may be a surrogate, it is up to the implementor to decide
    which value to return for this method.
    
 1. IdentifiableWithTimestamps
 
    A combination of Identifiable and Timestampable
 
 1. Nameable
 
    Adds a `name()` method that returns the entity name component.

 1. NumericallySortable
 
    Adds an `ordinal()` and update method for adding a numerical sorting index to an entity.

 1. Publishable
 
    Adds `publishAt()`/`unpublish()` for controlling if an Entity is "published". Uses the DateTime value object.
    
    Note: there is no trait as publishAt/unpublish are domain operations.
    
 1. Stringable
 
    Adds `__toString()` and a `toString()` method that will try to use the following methods:
    
     * `displayAs()`
     * `title()`
     * `name()`
     * property name
    
    If none are present the object class and identity are returned.
    
 1. Timestampable
 
    Adds methods for initialising and triggering updates to entity timestamps.

 1. Versionable
 
    Adds a `version()` and `incrementVersion()` methods for defining the current entity version. incrementVersion
    should be hooked in to appropriate update methods when the entity is modified.
    
### Utilities

 * EntityAccessor
   
   Helper class for accessing property methods/properties. Intended to be used in unit tests only.
