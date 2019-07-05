<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types\Web;

use Assert\Assert;

/**
 * Class IPv4Address
 *
 * @package    Somnambulist\Domain\Entities\Types\Web
 * @subpackage Somnambulist\Domain\Entities\Types\Web\IPv4Address
 */
class IPv4Address extends IpAddress
{

    /**
     * Constructor.
     *
     * @param string $ip
     */
    public function __construct(string $ip)
    {
        Assert::that($ip, null, 'ip')->notEmpty()->ipv4();

        $this->value = $ip;
    }
}
