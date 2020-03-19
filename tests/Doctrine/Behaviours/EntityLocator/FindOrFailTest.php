<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Doctrine\Behaviours\EntityLocator;

use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Doctrine\Behaviours\EntityLocator\FindOrFail;
use Somnambulist\Domain\Entities\Exceptions\EntityNotFoundException;

/**
 * Class FindOrFailTest
 *
 * @package    Somnambulist\Domain\Tests\Doctrine\Behaviours\EntityLocator
 * @subpackage Somnambulist\Domain\Tests\Doctrine\Behaviours\EntityLocator\FindOrFailTest
 *
 * @group doctrine
 * @group doctrine-behaviours
 * @group doctrine-behaviours-locator
 */
class FindOrFailTest extends TestCase
{

    public function testFindOrFailCallsFind()
    {
        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage('Entity "Entity" with identifier "1234" not found');

        $mock = $this->getMockForTrait(FindOrFail::class);
        $mock
            ->expects($this->once())
            ->method('find')
            ->willReturn(null)
        ;
        $mock
            ->expects($this->once())
            ->method('getEntityName')
            ->willReturn('Entity')
        ;

        /** @var FindOrFail $mock */
        $mock->findOrFail(1234);
    }

    public function testFindOrFailReturnsEntity()
    {
        $mock = $this->getMockForTrait(FindOrFail::class);
        $mock
            ->expects($this->once())
            ->method('find')
            ->willReturn(new \stdClass)
        ;

        /** @var FindOrFail $mock */
        $entity = $mock->findOrFail(1234);

        $this->assertInstanceOf(\stdClass::class, $entity);
    }

    public function testFindOneByOrFailCallsFindOneBy()
    {
        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage('Entity "Entity" with identifier "some name" not found');

        $mock = $this->getMockForTrait(FindOrFail::class);
        $mock
            ->expects($this->once())
            ->method('findOneBy')
            ->willReturn(null)
        ;
        $mock
            ->expects($this->once())
            ->method('getEntityName')
            ->willReturn('Entity')
        ;

        /** @var FindOrFail $mock */
        $mock->findOneByOrFail(['name' => 'some name']);
    }

    public function testFindOneByOrFailReturnsEntity()
    {
        $mock = $this->getMockForTrait(FindOrFail::class);
        $mock
            ->expects($this->once())
            ->method('findOneBy')
            ->willReturn(new \stdClass)
        ;

        /** @var FindOrFail $mock */
        $entity = $mock->findOneByOrFail(['name' => 'some name']);

        $this->assertInstanceOf(\stdClass::class, $entity);
    }
}
