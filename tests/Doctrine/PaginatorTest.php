<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Doctrine;

use Pagerfanta\Pagerfanta;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Domain\Doctrine\Paginator;
use Somnambulist\Components\Domain\Tests\Support\Behaviours\BuildDoctrineInstance;

/**
 * Class PaginatorTest
 *
 * @package    Somnambulist\Components\Domain\Tests\Doctrine
 * @subpackage Somnambulist\Components\Domain\Tests\Doctrine\PaginatorTest
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
