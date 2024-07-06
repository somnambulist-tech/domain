<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Support\Stubs\Models;

use Somnambulist\Components\Collection\MutableCollection as Collection;
use Somnambulist\Components\Models\Behaviours\CalculateDifferenceBetweenInstances;
use Somnambulist\Components\Models\Types\DateTime\DateTime;
use Somnambulist\Components\Models\Types\Identity\Uuid;
use Somnambulist\Components\Models\Types\Money\Money;
use Somnambulist\Components\Tests\Support\Stubs\Models\ValueObjects\Purchaser;

class Order
{
    use CalculateDifferenceBetweenInstances;

    protected ?int $id = null;
    protected Uuid $orderRef;
    protected Purchaser $purchaser;
    protected Money $total;
    protected DateTime $createdAt;
    protected Collection $properties;
    protected ?string $name = null;

    public function __construct(Uuid $orderRef, Purchaser $purchaser, Money $total, DateTime $date)
    {
        $this->orderRef   = $orderRef;
        $this->purchaser  = $purchaser;
        $this->total      = $total;
        $this->createdAt  = $date;
        $this->properties = new Collection();
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function orderRef(): Uuid
    {
        return $this->orderRef;
    }

    public function purchaser(): Purchaser
    {
        return $this->purchaser;
    }

    public function total(): Money
    {
        return $this->total;
    }

    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }

    public function properties(): Collection
    {
        return $this->properties;
    }
}
