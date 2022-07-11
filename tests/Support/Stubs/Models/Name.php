<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Support\Stubs\Models;

use Assert\Assert;
use Somnambulist\Components\Models\AbstractValueObject;

/**
 * Class Name
 *
 * @package    Somnambulist\Components\Tests\Support\Stubs\Models
 * @subpackage Somnambulist\Components\Tests\Support\Stubs\Models\Name
 */
final class Name extends AbstractValueObject
{

    private string $value;

    public function __construct(string $name)
    {
        Assert::that($name, null, 'name')->notNull()->notEmpty()->maxLength(255);

        $this->value = $name;
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
