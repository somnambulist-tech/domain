<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Doctrine\Behaviours\QueryBuilder;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Domain\Doctrine\Behaviours\QueryBuilder\HasJoinAlias;

/**
 * Class HasJoinAliasTest
 *
 * @package    Somnambulist\Components\Domain\Tests\Doctrine\Behaviours\QueryBuilder
 * @subpackage Somnambulist\Components\Domain\Tests\Doctrine\Behaviours\QueryBuilder\HasJoinAliasTest
 *
 * @group doctrine
 * @group doctrine-behaviours
 * @group doctrine-behaviours-dbal
 */
class HasJoinAliasTest extends TestCase
{

    public function testCanCheckForJoinAlias()
    {
        $test = $this->getMockForTrait(HasJoinAlias::class);

        $qb = new QueryBuilder($this->createMock(Connection::class));
        $qb->select('e')->from('Entity', 'e');

        $this->assertFalse($test->hasJoinAlias($qb, 'e'));

        $qb->join('e', 'another', 'a', 'a.this = e.that');

        $this->assertTrue($test->hasJoinAlias($qb, 'a'));
    }
}
