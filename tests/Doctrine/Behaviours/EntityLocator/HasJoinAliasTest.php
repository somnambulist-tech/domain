<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Doctrine\Behaviours\EntityLocator;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Doctrine\Behaviours\EntityLocator\HasJoinAlias;

#[Group('doctrine')]
#[Group('doctrine-behaviours')]
#[Group('doctrine-behaviours-locator')]
class HasJoinAliasTest extends TestCase
{
    public function testCanCheckForJoinAlias()
    {
        $test = new class { use HasJoinAlias; };

        $qb = new QueryBuilder($this->createMock(EntityManager::class));
        $qb->select('e')->from('Entity', 'e');

        $this->assertFalse($test->hasJoinAlias($qb, 'e'));

        $qb->join('e.another', 'a');

        $this->assertTrue($test->hasJoinAlias($qb, 'a'));
    }
}
