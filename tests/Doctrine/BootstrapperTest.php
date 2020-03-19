<?php

namespace Somnambulist\Domain\Tests\Doctrine;

use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Doctrine\TypeBootstrapper;

/**
 * Class BootstrapperTest
 *
 * @package    Somnambulist\Domain\Tests\Doctrine
 * @subpackage Somnambulist\Domain\Tests\Doctrine\BootstrapperTest
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
