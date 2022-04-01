<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities\Types\Web;

use Assert\Assert;

/**
 * Class IPV6Address
 *
 * @package    Somnambulist\Components\Domain\Entities\Types\Web
 * @subpackage Somnambulist\Components\Domain\Entities\Types\Web\IPV6Address
 */
final class IPV6Address extends IpAddress
{
    public function __construct(string $ip)
    {
        Assert::that($ip, null, 'ip')->notEmpty()->ipv6();

        $this->value = $ip;
    }
}
