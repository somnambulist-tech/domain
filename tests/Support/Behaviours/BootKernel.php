<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Support\Behaviours;

/**
 * @method void setKernelClass()
 * @method void setUpTests()
 */
trait BootKernel
{
    protected function setUp(): void
    {
        if (method_exists($this, 'setKernelClass')) {
            self::setKernelClass();
        }

        self::bootKernel();

        if (method_exists($this, 'setUpTests')) {
            $this->setUpTests();
        }
    }
}
