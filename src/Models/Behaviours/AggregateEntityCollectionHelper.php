<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Behaviours;

use Assert\Assertion;
use Assert\InvalidArgumentException;
use Doctrine\Common\Collections\Collection;
use Somnambulist\Components\Models\AbstractEntityCollection;
use function is_a;
use function sprintf;

/**
 * Provides instanced helpers for an aggregate root
 *
 * When working with standard `AbstractEntity` instances, it is important to be able to maintain
 * state to avoid issues with identity generation. This helper keeps helper instances after first
 * access, ensuring that testing for identities is consistent.
 */
trait AggregateEntityCollectionHelper
{
    private array $helpers = [];

    final protected function collectionHelperFor(Collection $collection, string $helperClass): AbstractEntityCollection
    {
        if (!is_a($helperClass, AbstractEntityCollection::class, allow_string: true)) {
            throw new InvalidArgumentException(
                sprintf('Provided helper class name was not a %s', AbstractEntityCollection::class),
                Assertion::INVALID_INSTANCE_OF
            );
        }

        return $this->helpers[$helperClass] ??= new $helperClass($this, $collection);
    }
}
