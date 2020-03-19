<?php

namespace Somnambulist\Domain\Tests\Support\Stubs\Models\ValueObjects;

use Somnambulist\Domain\Entities\AbstractValueObject;
use Somnambulist\Domain\Entities\Types\Geography\Country;
use Somnambulist\Domain\Entities\Types\Identity\EmailAddress;

class Purchaser extends AbstractValueObject
{

    private string $name;
    private EmailAddress $email;
    private Country $country;

    public function __construct(string $name, EmailAddress $email, Country $country)
    {
        $this->name    = $name;
        $this->email   = $email;
        $this->country = $country;
    }

    public function toString(): string
    {
        return $this->name;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): EmailAddress
    {
        return $this->email;
    }

    public function country(): Country
    {
        return $this->country;
    }
}
