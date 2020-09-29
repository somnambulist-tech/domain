<?php

namespace Somnambulist\Components\Domain\Tests\Doctrine;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Domain\Doctrine\TypeBootstrapper;

/**
 * Class BootstrapperTest
 *
 * @package    Somnambulist\Components\Domain\Tests\Doctrine
 * @subpackage Somnambulist\Components\Domain\Tests\Doctrine\BootstrapperTest
 *
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
