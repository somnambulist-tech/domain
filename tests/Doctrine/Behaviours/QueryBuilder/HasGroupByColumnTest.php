<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Doctrine\Behaviours\QueryBuilder;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Doctrine\Behaviours\QueryBuilder\HasGroupByColumn;

#[Group('doctrine')]
#[Group('doctrine-behaviours')]
#[Group('doctrine-behaviours-dbal')]
class HasGroupByColumnTest extends TestCase
{
    public function testCanCheckForGroupByColumn()
    {
        $test = new class { use HasGroupByColumn; };

        $qb = new QueryBuilder($this->createMock(Connection::class));
        $qb->select('e.id, e.name')->from('Entity', 'e');

        $this->assertFalse($test->hasColumnInGroupBy($qb, 'e.id'));

        $qb->groupBy('e.id');

        $this->assertTrue($test->hasColumnInGroupBy($qb, 'e.id'));
    }
}
