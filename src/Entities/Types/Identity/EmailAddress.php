<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities\Types\Identity;

use Assert\Assert;
use Somnambulist\Components\Domain\Entities\AbstractValueObject;

/**
 * Class EmailAddress
 *
 * @package    Somnambulist\Components\Domain\Entities\Types\Identity
 * @subpackage Somnambulist\Components\Domain\Entities\Types\Identity\EmailAddress
 */
final class EmailAddress extends AbstractValueObject
{
    public function __construct(private string $value)
    {
        Assert::that($value, null, 'email')->notEmpty()->email()->maxLength(100);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function account(): string
    {
        return mb_substr($this->value, 0, mb_strpos($this->value, '@'));
    }

    public function domain(): string
    {
        return mb_substr($this->value, mb_strpos($this->value, '@') + 1);
    }
}
