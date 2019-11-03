<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Doctrine\Behaviours\EntityLocator;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Doctrine\Behaviours\EntityLocator\FindByName;

/**
 * Class FindByNameTest
 *
 * @package    Somnambulist\Domain\Tests\Doctrine\Behaviours\EntityLocator
 * @subpackage Somnambulist\Domain\Tests\Doctrine\Behaviours\EntityLocator\FindByNameTest
 */
class FindByNameTest extends TestCase
{

    /**
     * @group traits
     */
    public function testFindByNameCallsFindBy()
    {
        $mock = $this->getMockForTrait(FindByName::class);
        $mock
            ->expects($this->once())
            ->method('findBy')
            ->willReturn(new ArrayCollection())
        ;

        /** @var FindByName $mock */
        $mock->findByName('bob');
    }

    /**
     * @group traits
     */
    public function testFindOneByNameCallsFindOneBy()
    {
        $mock = $this->getMockForTrait(FindByName::class);
        $mock
            ->expects($this->once())
            ->method('findOneBy')
        ;

        /** @var FindByName $mock */
        $mock->findOneByName('bob');
    }
}
