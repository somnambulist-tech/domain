<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Doctrine\Behaviours\QueryBuilder;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Doctrine\Behaviours\QueryBuilder\HasGroupByColumn;

/**
 * Class HasGroupByColumnTest
 *
 * @package    Somnambulist\Domain\Tests\Doctrine\Behaviours\QueryBuilder
 * @subpackage Somnambulist\Domain\Tests\Doctrine\Behaviours\QueryBuilder\HasGroupByColumnTest
 *
 * @group doctrine
 * @group doctrine-behaviours
 * @group doctrine-behaviours-dbal
 */
class HasGroupByColumnTest extends TestCase
{

    public function testCanCheckForGroupByColumn()
    {
        $test = $this->getMockForTrait(HasGroupByColumn::class);

        $qb = new QueryBuilder($this->createMock(Connection::class));
        $qb->select('e.id, e.name')->from('Entity', 'e');

        $this->assertFalse($test->hasColumnInGroupBy($qb, 'e.id'));

        $qb->groupBy('e.id');

        $this->assertTrue($test->hasColumnInGroupBy($qb, 'e.id'));
    }
}
