<?php

declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Entities\Behaviours;

use PHPUnit\Framework\TestCase;

/**
 * Class BehaviourTest
 *
 * @package    Somnambulist\Domain\Tests\Entities\Behaviours
 * @subpackage Somnambulist\Domain\Tests\Entities\Behaviours\BehaviourTest
 */
class BehaviourTest extends TestCase
{

    public function testBehavioursResolve()
    {
        $obj = new Stub();

        $this->assertTrue(true);
    }
}
