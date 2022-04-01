<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities\Types;

use Assert\Assert;
use Somnambulist\Components\Domain\Entities\AbstractValueObject;

/**
 * Class PhoneNumber
 *
 * Phone numbers are stored internally using E164 format. You should use a library
 * such as Giggsey PhoneNumber to convert a local string to E164 - the full
 * international format including leading +
 *
 * Note: allow sufficient storage space for the number, and always store the number
 * as a string and never an integer.
 *
 * @package    Somnambulist\Components\Domain\Entities\Types
 * @subpackage Somnambulist\Components\Domain\Entities\Types\PhoneNumber
 */
class PhoneNumber extends AbstractValueObject
{
    public function __construct(private string $value)
    {
        Assert::that($value, null, 'phone number')->notEmpty()->e164();
    }

    public function toString(): string
    {
        return $this->value;
    }
}
