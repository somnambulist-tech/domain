<?php

namespace Somnambulist\Domain\Tests\Doctrine\Helpers;

use Somnambulist\Domain\Tests\Doctrine\Enum\Gender;

/**
 * Class Constructor
 *
 * @package    Somnambulist\Tests\DoctrineEnumBridge\Helpers
 * @subpackage Somnambulist\Tests\DoctrineEnumBridge\Helpers\Constructor
 */
class Constructor
{
    public function __invoke($value)
    {
        if (null === $value) {
            return null;
        }

        if (null !== $gender = Gender::memberOrNullByValue($value)) {
            return $gender;
        }

        throw new \InvalidArgumentException(sprintf('"%s" not valid for "%s"', $value, Gender::class));
    }
}
