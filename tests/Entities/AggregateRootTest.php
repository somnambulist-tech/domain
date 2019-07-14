<?php

declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Entities;

use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Entities\AggregateRoot;

/**
 * Class AggregateRootTest
 *
 * @package    Somnambulist\Domain\Tests\Entities
 * @subpackage Somnambulist\Domain\Tests\Entities\AggregateRootTest
 */
class AggregateRootTest extends TestCase
{

    public function testResolves()
    {
        $ent = new class extends AggregateRoot {
            public function id()
            {

            }
        };

        $this->assertTrue(true);
    }
}
