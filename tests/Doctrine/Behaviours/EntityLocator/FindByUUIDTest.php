<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Doctrine\Behaviours\EntityLocator;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Domain\Doctrine\Behaviours\EntityLocator\FindByUUID;
use Somnambulist\Components\Domain\Entities\Exceptions\EntityNotFoundException;
use Somnambulist\Components\Domain\Entities\Types\Identity\Uuid;

/**
 * Class FindByUUIDTest
 *
 * @package    Somnambulist\Components\Domain\Tests\Doctrine\Behaviours\EntityLocator
 * @subpackage Somnambulist\Components\Domain\Tests\Doctrine\Behaviours\EntityLocator\FindByUUIDTest
 *
 * @group doctrine
 * @group doctrine-behaviours
 * @group doctrine-behaviours-locator
 */
class FindByUUIDTest extends TestCase
{

    public function testFindByUUIDCallsFindOneBy()
    {
        $mock = $this->getMockForTrait(FindByUUID::class);
        $mock
            ->expects($this->once())
            ->method('findOneBy')
        ;

        /** @var FindByUUID $mock */
        $mock->findByUUID(new Uuid('86cc267d-428c-4107-9abc-4b7e20e551bb'));
    }

    public function testFindOrFailByUUIDCallsFindOneBy()
    {
        $mock = $this->getMockForTrait(FindByUUID::class);
        $mock
            ->expects($this->once())
            ->method('findOneBy')
            ->willReturn(new \stdClass())
        ;

        /** @var FindByUUID $mock */
        $mock->findOrFailByUUID(new Uuid('8c21dae8-47b1-40b0-8ea4-478e181aff63'));
    }

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
        $mock->findOrFailByUUID(new Uuid('e02acdf9-697e-4166-baa7-52e342e2b4a6'));
    }
}
