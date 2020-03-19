<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Doctrine\Behaviours\EntityLocator;

use PHPUnit\Framework\TestCase;
use Somnambulist\Collection\MutableCollection;
use Somnambulist\Domain\Doctrine\Behaviours\EntityLocator\FindByName;

/**
 * Class FindByNameTest
 *
 * @package    Somnambulist\Domain\Tests\Doctrine\Behaviours\EntityLocator
 * @subpackage Somnambulist\Domain\Tests\Doctrine\Behaviours\EntityLocator\FindByNameTest
 *
 * @group doctrine
 * @group doctrine-behaviours
 * @group doctrine-behaviours-locator
 */
class FindByNameTest extends TestCase
{

    public function testFindByNameCallsFindBy()
    {
        $mock = $this->getMockForTrait(FindByName::class);
        $mock
            ->expects($this->once())
            ->method('findBy')
            ->willReturn(new MutableCollection())
        ;

        /** @var FindByName $mock */
        $mock->findByName('bob');
    }

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
