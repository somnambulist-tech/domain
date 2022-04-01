<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities\Types\Identity;

use Assert\Assert;
use Somnambulist\Components\Domain\Entities\AbstractValueObject;

/**
 * Class ExternalIdentity
 *
 * @package    Somnambulist\Components\Domain\Entities\Types\Identity
 * @subpackage Somnambulist\Components\Domain\Entities\Types\Identity\ExternalIdentity
 */
final class ExternalIdentity extends AbstractValueObject
{
    public function __construct(private string $provider, private string $identity)
    {
        Assert::lazy()->tryAll()
            ->that($provider, 'provider')->notEmpty()->notBlank()->maxLength(50)
            ->that($identity, 'identity')->notEmpty()->notBlank()->maxLength(100)
            ->verifyNow()
        ;
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
