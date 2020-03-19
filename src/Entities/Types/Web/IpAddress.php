<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types\Web;

use Somnambulist\Domain\Entities\AbstractValueObject;

/**
 * Class IpAddress
 *
 * @package    Somnambulist\Domain\Entities\Types\Web
 * @subpackage Somnambulist\Domain\Entities\Types\Web\IpAddress
 */
abstract class IpAddress extends AbstractValueObject
{

    protected string $value;

    public function toString(): string
    {
        return (string)$this->value;
    }
}
