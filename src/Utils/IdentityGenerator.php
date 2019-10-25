<?php declare(strict_types=1);

namespace Somnambulist\Domain\Utils;

use Ramsey\Uuid\Uuid as UuidFactory;
use Somnambulist\Domain\Entities\Types\Identity\Uuid;
use function implode;

/**
 * Class IdentityGenerator
 *
 * @package Somnambulist\Domain\Utils
 * @subpackage Somnambulist\Domain\Utils\IdentityGenerator
 */
final class IdentityGenerator
{

    /**
     * Creates a new UUID v4 identity
     *
     * @return Uuid
     */
    public static function new(): Uuid
    {
        return new Uuid(UuidFactory::uuid4()->toString());
    }

    /**
     * Creates a UUID v5 in the provided namespace using the values
     *
     * Multiple string values can be passed and they will be dot separated as the identity
     * string. E.g.: `IdentityGenerator::hashed($ns, 'var', 'foo', 'bar')` would hash the
     * string "var.foo.bar" (without quotes).
     *
     * This will produce the same UUID provided the arguments and namespace passed in are
     * the same. It's useful to generate a UUID from e.g.: a domain name / URL resource that
     * should always hash to the same thing.
     *
     * @param Uuid   $namespace
     * @param string ...$values
     *
     * @return Uuid
     */
    public static function hashed(Uuid $namespace, ...$values): Uuid
    {
        return new Uuid(UuidFactory::uuid5((string)$namespace, implode('.', $values))->toString());
    }
}
