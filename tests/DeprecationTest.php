<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests;

use PHPUnit\Framework\TestCase;

class DeprecationTest extends TestCase
{
    public function testOldNamespace()
    {
        $this->assertTrue(class_exists('Somnambulist\Components\Domain\Commands\AbstractCommand'));
        $this->assertTrue(class_exists('Somnambulist\Components\Domain\Doctrine\AbstractEntityLocator'));
        $this->assertTrue(class_exists('Somnambulist\Components\Domain\Entities\AbstractEntity'));
        $this->assertTrue(class_exists('Somnambulist\Components\Domain\Events\AbstractEvent'));
        $this->assertTrue(class_exists('Somnambulist\Components\Domain\Jobs\AbstractJob'));
        $this->assertTrue(class_exists('Somnambulist\Components\Domain\Queries\AbstractQuery'));
        $this->assertTrue(class_exists('Somnambulist\Components\Domain\Utils\EntityAccessor'));
    }
}
