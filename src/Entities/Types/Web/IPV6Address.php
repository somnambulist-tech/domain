<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types\Web;

use Assert\Assert;

/**
 * Class IPV6Address
 *
 * @package    Somnambulist\Domain\Entities\Types\Web
 * @subpackage Somnambulist\Domain\Entities\Types\Web\IPV6Address
 */
final class IPV6Address extends IpAddress
{

    public function __construct(string $ip)
    {
        Assert::that($ip, null, 'ip')->notEmpty()->ipv6();

        $this->value = $ip;
    }
}
