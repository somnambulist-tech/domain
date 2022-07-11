<?php

namespace Somnambulist\Components\Tests\Doctrine;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Doctrine\TypeBootstrapper;

/**
 * @group doctrine
 * @group doctrine-bootstrapper
 */
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
