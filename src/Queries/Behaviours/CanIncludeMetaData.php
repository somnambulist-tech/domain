<?php declare(strict_types=1);

namespace Somnambulist\Components\Queries\Behaviours;

use Somnambulist\Components\Collection\FrozenCollection;
use function array_merge;

trait CanIncludeMetaData
{
    private ?FrozenCollection $meta = null;

    public function addMetaData(array $data): static
    {
        $this->meta = new FrozenCollection($data);

        return $this;
    }

    public function appendMetaData(array $data): static
    {
        $this->meta = new FrozenCollection(array_merge($this->meta->toArray(), $data));

        return $this;
    }

    public function meta(): FrozenCollection
    {
        return $this->meta;
    }
}
