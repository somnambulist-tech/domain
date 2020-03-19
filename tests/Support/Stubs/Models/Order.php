<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Support\Stubs\Models;

use Somnambulist\Collection\MutableCollection as Collection;
use Somnambulist\Domain\Entities\Types\DateTime\DateTime;
use Somnambulist\Domain\Entities\Types\Identity\Uuid;
use Somnambulist\Domain\Entities\Types\Money\Money;
use Somnambulist\Domain\Tests\Support\Stubs\Models\ValueObjects\Purchaser;

class Order
{

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
