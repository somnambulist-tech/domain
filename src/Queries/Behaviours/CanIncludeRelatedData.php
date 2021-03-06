<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Queries\Behaviours;

use function count;
use function is_array;

/**
 * Trait CanIncludeRelatedData
 *
 * @package Somnambulist\Components\Domain\Queries\Behaviours
 * @subpackage Somnambulist\Components\Domain\Queries\Behaviours\CanIncludeRelatedData
 */
trait CanIncludeRelatedData
{

    private array $includes = [];

    /**
     * Add related data to be loaded with the query request
     *
     * @param string ...$includes Either an array of includes or multiple single string arguments
     *
     * @return static
     */
    public function with(...$includes): self
    {
        if (count($includes) === 1 && is_array($includes[0])) {
            $includes = $includes[0];
        }

        $this->includes = $includes;

        return $this;
    }

    public function getIncludes(): array
    {
        return $this->includes;
    }
}
