<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types\Web;

use Assert\Assert;

final readonly class IPV6Address extends IpAddress
{
    public function __construct(string $ip)
    {
        Assert::that($ip, null, 'ip')->notEmpty()->ipv6();

        parent::__construct($ip);
    }
}
