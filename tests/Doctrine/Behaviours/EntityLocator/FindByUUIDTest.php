<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Doctrine\Behaviours\EntityLocator;

use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Doctrine\Behaviours\EntityLocator\FindByUUID;
use Somnambulist\Domain\Entities\Exceptions\EntityNotFoundException;

/**
 * Class FindByUUIDTest
 *
 * @package    Somnambulist\Domain\Tests\Doctrine\Behaviours\EntityLocator
 * @subpackage Somnambulist\Domain\Tests\Doctrine\Behaviours\EntityLocator\FindByUUIDTest
 */
class FindByUUIDTest extends TestCase
{

    /**
     * @group traits
     */
    public function testFindByUUIDCallsFindOneBy()
    {
        $mock = $this->getMockForTrait(FindByUUID::class);
        $mock
            ->expects($this->once())
            ->method('findOneBy')
        ;

        /** @var FindByUUID $mock */
        $mock->findByUUID('bob');
    }

    /**
     * @group traits
     */
    public function testFindOrFailByUUIDCallsFindOneBy()
    {
        $mock = $this->getMockForTrait(FindByUUID::class);
        $mock
            ->expects($this->once())
            ->method('findOneBy')
            ->willReturn(new \stdClass())
        ;

        /** @var FindByUUID $mock */
        $mock->findOrFailByUUID('bob');
    }

    /**
     * @group traits
     */
    public function testFindOrFailByUUIDCallsRaisesExceptionIfNotFound()
    {
        $mock = $this->getMockForTrait(FindByUUID::class, [], '', true, true, true, ['findByUUID']);
        $mock
            ->expects($this->once())
            ->method('findByUUID')
            ->willReturn(null)
        ;
        $mock
            ->expects($this->once())
            ->method('getEntityName')
            ->willReturn('class')
        ;

        $this->expectException(EntityNotFoundException::class);
        /** @var FindByUUID $mock */
        $mock->findOrFailByUUID('bob');
    }
}
