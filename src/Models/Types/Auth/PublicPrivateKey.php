<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types\Auth;

use Assert\Assert;
use Somnambulist\Components\Models\AbstractValueObject;

/**
 * Represents a public/private key combination in the domain
 */
final readonly class PublicPrivateKey extends AbstractValueObject
{
    public function __construct(private string $publicKey, private string $privateKey)
    {
        Assert::lazy()->tryAll()
            ->that($publicKey, 'publicKey')->notEmpty()->maxLength(64)
            ->that($privateKey, 'privateKey')->notEmpty()->maxLength(255)
            ->verifyNow()
        ;
    }

    public function toString(): string
    {
        return $this->publicKey;
    }

    public function publicKey(): string
    {
        return $this->publicKey;
    }

    public function privateKey(): string
    {
        return $this->privateKey;
    }
}
