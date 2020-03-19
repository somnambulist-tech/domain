<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Doctrine;

use Pagerfanta\Pagerfanta;
use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Doctrine\Paginator;
use Somnambulist\Domain\Tests\Support\Behaviours\BuildDoctrineInstance;

/**
 * Class PaginatorTest
 *
 * @package    Somnambulist\Domain\Tests\Doctrine
 * @subpackage Somnambulist\Domain\Tests\Doctrine\PaginatorTest
 *
 * @group doctrine
 * @group doctrine-paginator
 */
class PaginatorTest extends TestCase
{

    use BuildDoctrineInstance;

    public function testCanPaginateQuery()
    {
        $paginator = new Paginator($this->em->createQuery());
        $results = $paginator->paginate(20, 1);

        $this->assertInstanceOf(Pagerfanta::class, $results);
    }
}
