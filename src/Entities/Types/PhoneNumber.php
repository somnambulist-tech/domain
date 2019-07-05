<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types;

use Assert\Assert;
use Somnambulist\Domain\Entities\AbstractValueObject;

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
 * @package    Somnambulist\Domain\Entities\Types
 * @subpackage Somnambulist\Domain\Entities\Types\PhoneNumber
 */
class PhoneNumber extends AbstractValueObject
{

    /**
     * @var string
     */
    private $value;

    /**
     * Constructor.
     *
     * @param string $number
     */
    public function __construct($number)
    {
        Assert::that($number, null, 'number')->notEmpty()->e164();

        $this->value = $number;
    }

    public function toString(): string
    {
        return (string)$this->value;
    }
}
