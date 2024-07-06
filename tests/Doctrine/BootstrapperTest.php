<?php

namespace Somnambulist\Components\Tests\Doctrine;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Doctrine\TypeBootstrapper;

#[Group('doctrine')]
#[Group('doctrine-bootstrapper')]
class BootstrapperTest extends TestCase
{
    public function testCanCallBootstrapRegisterTypesMultipleTimes()
    {
        TypeBootstrapper::registerTypes(TypeBootstrapper::$types);
        TypeBootstrapper::registerTypes(TypeBootstrapper::$types);
        TypeBootstrapper::registerTypes(TypeBootstrapper::$types);
        TypeBootstrapper::registerTypes(TypeBootstrapper::$types);

        $this->assertTrue(true);
    }
}
