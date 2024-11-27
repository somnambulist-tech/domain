<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Queries;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Collection\FrozenCollection;
use Somnambulist\Components\Queries\AbstractPaginatableQuery;

#[Group('queries')]
#[Group('queries-paginatable')]
class AbstractPaginatableQueryTest extends TestCase
{
    public function testPropertyAssignment()
    {
        $criteria = [
            'email_address' => '%@example.com',
            'country'       => 'CAN',
        ];

        $query = new class ($criteria, [], 2, 10) extends AbstractPaginatableQuery {};

        $this->assertEquals(2, $query->page());
        $this->assertEquals(10, $query->perPage());
        $this->assertInstanceOf(FrozenCollection::class, $query->criteria());
        $this->assertInstanceOf(FrozenCollection::class, $query->orderBy());
        $this->assertIsArray($query->includes());
        $this->assertCount(2, $query->criteria());
        $this->assertCount(0, $query->orderBy());
    }

    public function testCanAddIncludes()
    {
        $query = new class ([], [], 2, 10) extends AbstractPaginatableQuery {};
        $query->include('user.address');

        $this->assertEquals(['user.address'], $query->includes());
    }

    public function testCanAddMetaData()
    {
        $query = new class ([], [], 2, 10) extends AbstractPaginatableQuery {};
        $query->addMetaData(['include' => 'user.address']);

        $this->assertTrue($query->meta()->has('include'));
    }
}
