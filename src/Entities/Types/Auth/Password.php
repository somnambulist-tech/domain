<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types\Auth;

use Assert\Assert;
use Somnambulist\Domain\Entities\AbstractValueObject;
use function password_get_info;
use function strtolower;

/**
 * Class Password
 *
 * @package    Somnambulist\Domain\Entities\Types\Auth
 * @subpackage Somnambulist\Domain\Entities\Types\Auth\Password
 */
class Password extends AbstractValueObject
{

    private string $value;

    public function __construct(string $value)
    {
        Assert::that($value, null, 'password')->notEmpty()->notBlank()->maxLength(255)->satisfy(function ($string) {
            $info = password_get_info($string);

            return 0 !== $info['algo'] && 'unknown' !== strtolower($info['algoName']);
        }, 'The password string must be pre-hashed');

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function toString(): string
    {
        return $this->value;
    }
}
