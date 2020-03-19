<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types\Identity;

use Assert\Assert;
use Somnambulist\Domain\Entities\AbstractValueObject;

/**
 * Class ExternalIdentity
 *
 * @package    Somnambulist\Domain\Entities\Types\Identity
 * @subpackage Somnambulist\Domain\Entities\Types\Identity\ExternalIdentity
 */
final class ExternalIdentity extends AbstractValueObject
{

    private string $provider;
    private string $identity;

    public function __construct(string $provider, string $identity)
    {
        Assert::lazy()->tryAll()
            ->that($provider, 'provider')->notEmpty()->notBlank()->maxLength(50)
            ->that($identity, 'identity')->notEmpty()->notBlank()->maxLength(100)
            ->verifyNow()
        ;

        $this->provider = $provider;
        $this->identity = $identity;
    }

    public function toString(): string
    {
        return sprintf('%s:%s', $this->provider, $this->identity);
    }

    public function provider(): string
    {
        return $this->provider;
    }

    public function identity(): string
    {
        return $this->identity;
    }
}
