<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Behaviours;

use Somnambulist\Domain\Entities\Contracts\Nameable as NameableContract;

/**
 * Trait Stringable
 *
 * @package    Somnambulist\Domain\Entities\Behaviours
 * @subpackage Somnambulist\Domain\Entities\Behaviours\Stringable
 */
trait Stringable
{

    public function __toString()
    {
        return (string)$this->toString();
    }

    public function toString(): string
    {
        if (method_exists($this, 'displayAs')) {
            return $this->displayAs();
        }
        if (method_exists($this, 'title')) {
            return $this->title();
        }
        if ($this instanceof NameableContract) {
            return $this->name();
        }
        if (property_exists($this, 'name')) {
            return $this->name;
        }

        return sprintf('%s: %s', get_class($this), $this->id());
    }
}
