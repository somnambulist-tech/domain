<?php

namespace Somnambulist\Domain\Tests\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Somnambulist\Domain\Doctrine\EnumerationBridge;

/**
 * Class MyType
 *
 * @package    Somnambulist\Domain\Tests\Doctrine
 * @subpackage Somnambulist\Domain\Tests\Doctrine\MyType
 */
class MyType extends EnumerationBridge
{
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'FOO BAR';
    }
}
