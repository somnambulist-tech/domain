<?php declare(strict_types=1);

namespace Somnambulist\Components\Queries\Behaviours;

trait CanIncludeRelatedData
{
    private array $includes = [];

    /**
     * Add related data to be loaded with the query request
     *
     * @param string ...$include A set of strings for each sub-object to include in the response
     *
     * @return static
     */
    public function include(string ...$include): static
    {
        $this->includes = $include;

        return $this;
    }

    public function includes(): array
    {
        return $this->includes;
    }
}
