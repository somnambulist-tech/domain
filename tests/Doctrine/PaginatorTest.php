<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Doctrine;

use Pagerfanta\Pagerfanta;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Doctrine\Paginator;
use Somnambulist\Components\Tests\Support\Behaviours\BuildDoctrineInstance;

/**
 * @group doctrine
 * @group doctrine-paginator
 */
class PaginatorTest extends TestCase
{
    use BuildDoctrineInstance;

    public function testCanPaginateQuery()
    {
        $paginator = new Paginator($this->em->createQuery());
        $results = $paginator->paginate();

        $this->assertInstanceOf(Pagerfanta::class, $results);
    }
}
