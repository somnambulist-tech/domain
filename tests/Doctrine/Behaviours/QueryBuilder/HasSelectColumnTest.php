<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Doctrine\Behaviours\QueryBuilder;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Doctrine\Behaviours\QueryBuilder\HasSelectColumn;

/**
 * @group doctrine
 * @group doctrine-behaviours
 * @group doctrine-behaviours-dbal
 */
class HasSelectColumnTest extends TestCase
{
    public function testCanCheckForColumnInSelect()
    {
        $test = $this->getMockForTrait(HasSelectColumn::class);

        $qb = new QueryBuilder($this->createMock(Connection::class));
        $qb->select('e.id', 'e.name')->from('Entity', 'e');

        $this->assertFalse($test->hasColumnInSelect($qb, 'e.updated_at'));

        $qb->addSelect('e.updated_at');

        $this->assertTrue($test->hasColumnInSelect($qb, 'e.updated_at'));
    }
}
