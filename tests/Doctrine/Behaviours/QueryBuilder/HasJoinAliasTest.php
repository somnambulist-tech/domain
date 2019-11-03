<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Doctrine\Behaviours\QueryBuilder;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Doctrine\Behaviours\QueryBuilder\HasJoinAlias;

/**
 * Class HasJoinAliasTest
 *
 * @package    Somnambulist\Domain\Tests\Doctrine\Behaviours\QueryBuilder
 * @subpackage Somnambulist\Domain\Tests\Doctrine\Behaviours\QueryBuilder\HasJoinAliasTest
 */
class HasJoinAliasTest extends TestCase
{

    /**
     * @group traits
     */
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
