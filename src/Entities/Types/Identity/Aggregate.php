<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types\Identity;

use Assert\Assert;
use Somnambulist\Domain\Entities\AbstractValueObject;

/**
 * Class Aggregate
 *
 * @package    Somnambulist\Domain\Entities\Types\Identity
 * @subpackage Somnambulist\Domain\Entities\Types\Identity\Aggregate
 */
final class Aggregate extends AbstractValueObject
{

    private string $class;
    private string $identity;
    
    public function __construct(string $class, string $identity)
    {
        Assert::lazy()->tryAll()
            ->that($class, 'class')->notEmpty()->maxLength(255)
            ->that($identity, 'identity')->notEmpty()->uuid()
            ->verifyNow()
        ;

        $this->class    = $class;
        $this->identity = $identity;
    }

    public function toString(): string
    {
        return sprintf('%s:%s', $this->class, $this->identity);
    }

    public function class(): string
    {
        return $this->class;
    }

    public function identity(): string
    {
        return (string)$this->identity;
    }
}
