<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities\Types\Web;

use Somnambulist\Components\Domain\Entities\AbstractValueObject;

/**
 * Class IpAddress
 *
 * @package    Somnambulist\Components\Domain\Entities\Types\Web
 * @subpackage Somnambulist\Components\Domain\Entities\Types\Web\IpAddress
 */
abstract class IpAddress extends AbstractValueObject
{
    protected string $value;

    public function toString(): string
    {
        return $this->value;
    }
}
