<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities\Types\Auth;

use Assert\Assert;
use Somnambulist\Components\Domain\Entities\AbstractValueObject;

/**
 * Class PublicPrivateKey
 *
 * @package    Somnambulist\Components\Domain\Entities\Types\Auth
 * @subpackage Somnambulist\Components\Domain\Entities\Types\Auth\PublicPrivateKey
 */
class PublicPrivateKey extends AbstractValueObject
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
