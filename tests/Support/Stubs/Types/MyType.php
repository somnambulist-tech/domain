<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Support\Stubs\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Somnambulist\Domain\Doctrine\Types\EnumerationBridge;

class MyType extends EnumerationBridge
{
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'FOO BAR';
    }
}
