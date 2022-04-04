<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Support\Behaviours;

/**
 * Trait BootKernel
 *
 * @package    Somnambulist\Components\Domain\Tests\Support\Behaviours
 * @subpackage Somnambulist\Components\Domain\Tests\Support\Behaviours\BootKernel
 *
 * @method void setKernelClass()
 * @method void setUpTests()
 */
trait BootKernel
{

    /**
     * {@inheritDoc}
     */
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
