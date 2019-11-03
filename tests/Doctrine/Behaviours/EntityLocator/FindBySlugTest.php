<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Doctrine\Behaviours\EntityLocator;

use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Doctrine\Behaviours\EntityLocator\FindBySlug;
use Somnambulist\Domain\Entities\Exceptions\EntityNotFoundException;

/**
 * Class FindBySlugTest
 *
 * @package    Somnambulist\Domain\Tests\Doctrine\Behaviours\EntityLocator
 * @subpackage Somnambulist\Domain\Tests\Doctrine\Behaviours\EntityLocator\FindBySlugTest
 */
class FindBySlugTest extends TestCase
{

    /**
     * @group traits
     */
    public function testFindBySlugCallsFindOneBy()
    {
        $mock = $this->getMockForTrait(FindBySlug::class);
        $mock
            ->expects($this->once())
            ->method('findOneBy')
        ;

        /** @var FindBySlug $mock */
        $mock->findBySlug('bob');
    }

    /**
     * @group traits
     */
    public function testFindOrFailBySlugCallsFindOneBy()
    {
        $mock = $this->getMockForTrait(FindBySlug::class);
        $mock
            ->expects($this->once())
            ->method('findOneBy')
            ->willReturn(new \stdClass())
        ;

        /** @var FindBySlug $mock */
        $mock->findOrFailBySlug('bob');
    }

    /**
     * @group traits
     */
    public function testFindOrFailBySlugCallsRaisesExceptionIfNotFound()
    {
        $mock = $this->getMockForTrait(FindBySlug::class, [], '', true, true, true, ['findBySlug']);
        $mock
            ->expects($this->once())
            ->method('findBySlug')
            ->willReturn(null)
        ;
        $mock
            ->expects($this->once())
            ->method('getEntityName')
            ->willReturn('class')
        ;

        $this->expectException(EntityNotFoundException::class);
        /** @var FindBySlug $mock */
        $mock->findOrFailBySlug('bob');
    }
}
