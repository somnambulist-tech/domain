<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types\Identity;

use Somnambulist\Domain\Entities\AbstractValueObject;

/**
 * Class Aggregate
 *
 * @package    Somnambulist\Domain\Entities\Types\Identity
 * @subpackage Somnambulist\Domain\Entities\Types\Identity\Aggregate
 */
class Aggregate extends AbstractValueObject
{

    /**
     * @var string
     */
    private $class;

    /**
     * @var string
     */
    private $identity;

    /**
     * Constructor.
     *
     * @param string $class
     * @param string $identity A type supporting casting to a string
     */
    public function __construct(string $class, $identity)
    {
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
