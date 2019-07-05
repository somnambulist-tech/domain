<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types\Auth;

use Assert\Assert;
use Somnambulist\Domain\Entities\AbstractValueObject;

/**
 * Class PublicPrivateKey
 *
 * @package    Somnambulist\Domain\Entities\Types\Auth
 * @subpackage Somnambulist\Domain\Entities\Types\Auth\PublicPrivateKey
 */
class PublicPrivateKey extends AbstractValueObject
{

    /**
     * @var string
     */
    private $publicKey;

    /**
     * @var string
     */
    private $privateKey;

    /**
     * Constructor.
     *
     * @param string $publicKey
     * @param string $privateKey
     */
    public function __construct(string $publicKey, string $privateKey)
    {
        Assert::lazy()->tryAll()
            ->that($publicKey, 'publicKey')->notEmpty()->maxLength(64)
            ->that($privateKey, 'privateKey')->notEmpty()->maxLength(255)
            ->verifyNow()
        ;

        $this->publicKey  = $publicKey;
        $this->privateKey = $privateKey;
    }

    public function toString(): string
    {
        return (string)$this->publicKey;
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
