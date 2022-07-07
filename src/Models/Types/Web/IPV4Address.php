<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types\Web;

use Assert\Assert;

final class IPV4Address extends IpAddress
{
    public function __construct(string $ip)
    {
        Assert::that($ip, null, 'ip')->notEmpty()->ipv4();

        $this->value = $ip;
    }
}
