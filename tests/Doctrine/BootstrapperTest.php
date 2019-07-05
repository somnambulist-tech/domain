<?php

namespace Somnambulist\Domain\Tests\Doctrine;

use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Doctrine\Bootstrapper;

/**
 * Class BootstrapperTest
 *
 * @package    Somnambulist\Domain\Tests\Doctrine
 * @subpackage Somnambulist\Domain\Tests\Doctrine\BootstrapperTest
 */
class BootstrapperTest extends TestCase
{

    public function testCanCallBootstrapRegisterTypesMultipleTimes()
    {
        Bootstrapper::registerTypes();
        Bootstrapper::registerTypes();
        Bootstrapper::registerTypes();
        Bootstrapper::registerTypes();
        $this->assertTrue(true);
    }
}
