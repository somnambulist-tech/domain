<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Doctrine\Behaviours\EntityLocator;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Doctrine\Behaviours\EntityLocator\HasJoinAlias;

/**
 * Class HasJoinAliasTest
 *
 * @package    Somnambulist\Domain\Tests\Doctrine\Behaviours\EntityLocator
 * @subpackage Somnambulist\Domain\Tests\Doctrine\Behaviours\EntityLocator\HasJoinAliasTest
 *
 * @group doctrine
 * @group doctrine-behaviours
 * @group doctrine-behaviours-locator
 */
class HasJoinAliasTest extends TestCase
{

    public function testCanCheckForJoinAlias()
    {
        $test = $this->getMockForTrait(HasJoinAlias::class);

        $qb = new QueryBuilder($this->createMock(EntityManager::class));
        $qb->select('e')->from('Entity', 'e');

        $this->assertFalse($test->hasJoinAlias($qb, 'e'));

        $qb->join('e.another', 'a');

        $this->assertTrue($test->hasJoinAlias($qb, 'a'));
    }
}
