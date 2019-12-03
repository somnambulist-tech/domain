<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Queries;

use BadMethodCallException;
use PHPUnit\Framework\TestCase;
use Somnambulist\Collection\FrozenCollection;
use Somnambulist\Domain\Queries\AbstractPaginatableQuery;

/**
 * Class AbstractPaginatableQueryTest
 *
 * @package Somnambulist\Domain\Tests\Queries
 * @subpackage Somnambulist\Domain\Tests\Queries\AbstractPaginatableQueryTest
 *
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

        $this->assertEquals(2, $query->getPage());
        $this->assertEquals(10, $query->getPerPage());
        $this->assertInstanceOf(FrozenCollection::class, $query->getCriteria());
        $this->assertInstanceOf(FrozenCollection::class, $query->getOrderBy());
        $this->assertIsArray($query->getIncludes());
        $this->assertCount(2, $query->getCriteria());
        $this->assertCount(0, $query->getOrderBy());
    }

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

    public function testMethodPassThroughReturnsNullIfNotInCriteria()
    {
        $criteria = [
            'email_address' => '%@example.com',
        ];

        $query = new class($criteria, [], 2, 10) extends AbstractPaginatableQuery {};

        $this->assertNull($query->getCountry());
    }

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
