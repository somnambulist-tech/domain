<?php

namespace Somnambulist\Components\Tests\Support\Stubs\Models\ValueObjects;

use Somnambulist\Components\Models\AbstractValueObject;
use Somnambulist\Components\Models\Behaviours\CalculateDifferenceBetweenInstances;
use Somnambulist\Components\Models\Behaviours\CastValueObjectToArray;
use Somnambulist\Components\Models\Types\Geography\Country;
use Somnambulist\Components\Models\Types\Identity\EmailAddress;

class Purchaser extends AbstractValueObject
{

    use CastValueObjectToArray;
    use CalculateDifferenceBetweenInstances;

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
