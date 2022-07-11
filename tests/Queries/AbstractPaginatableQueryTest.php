<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Queries;

use BadMethodCallException;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Collection\FrozenCollection;
use Somnambulist\Components\Queries\AbstractPaginatableQuery;

/**
 * @group queries
 * @group queries-paginatable-query
 */
class AbstractPaginatableQueryTest extends TestCase
{
    public function testPropertyAssignment()
    {
        $criteria = [
            'email_address' => '%@example.com',
            'country'       => 'CAN',
        ];

        $query = new class($criteria, [], 2, 10) extends AbstractPaginatableQuery {};

        $this->assertEquals(2, $query->page());
        $this->assertEquals(10, $query->perPage());
        $this->assertInstanceOf(FrozenCollection::class, $query->criteria());
        $this->assertInstanceOf(FrozenCollection::class, $query->orderBy());
        $this->assertIsArray($query->includes());
        $this->assertCount(2, $query->criteria());
        $this->assertCount(0, $query->orderBy());
    }

    /**
     * @todo remove
     */
    public function testMethodPassThrough()
    {
        $criteria = [
            'email_address' => '%@example.com',
            'country'       => 'CAN',
        ];

        $query = new class($criteria, [], 2, 10) extends AbstractPaginatableQuery {};

        $this->assertEquals('CAN', $query->getCountry());
        $this->assertEquals('%@example.com', $query->getEmailAddress());
    }

    /**
     * @todo remove
     */
    public function testMethodPassThroughReturnsNullIfNotInCriteria()
    {
        $criteria = [
            'email_address' => '%@example.com',
        ];

        $query = new class($criteria, [], 2, 10) extends AbstractPaginatableQuery {};

        $this->assertNull($query->getCountry());
    }

    /**
     * @todo remove
     */
    public function testMethodPassThroughRaisesExceptionIfNotPrefixedWithGet()
    {
        $criteria = [
            'email_address' => '%@example.com',
            'country'       => 'CAN',
        ];

        $query = new class($criteria, [], 2, 10) extends AbstractPaginatableQuery {};

        $this->expectException(BadMethodCallException::class);

        $query->country();
    }
}
