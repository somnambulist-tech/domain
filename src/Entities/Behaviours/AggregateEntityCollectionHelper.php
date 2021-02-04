<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities\Behaviours;

use Assert\Assertion;
use Assert\InvalidArgumentException;
use Doctrine\Common\Collections\Collection;
use Somnambulist\Components\Domain\Entities\AbstractEntityCollection;
use function is_a;
use function sprintf;

/**
 * Trait AggregateEntityCollectionHelper
 *
 * @package    Somnambulist\Components\Domain\Entities\Behaviours
 * @subpackage Somnambulist\Components\Domain\Entities\Behaviours\AggregateEntityCollectionHelper
 */
trait AggregateEntityCollectionHelper
{

    private array $helpers = [];

    final protected function collectionHelperFor(Collection $collection, string $helperClass): AbstractEntityCollection
    {
        if (!is_a($helperClass, AbstractEntityCollection::class, allow_string: true)) {
            throw new InvalidArgumentException(
                sprintf('Provided helper class name was not an %s', AbstractEntityCollection::class),
                Assertion::INVALID_INSTANCE_OF
            );
        }

        return $this->helpers[$helperClass] ??= new $helperClass($this, $collection);
    }
}
