<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Doctrine\Functions;

use Doctrine\ORM\Query;
use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Doctrine\Functions\TypeFunction;
use Somnambulist\Domain\Tests\Support\Behaviours\BuildDoctrineInstance;

/**
 * Class TypeFunctionTest
 *
 * @package    Somnambulist\Domain\Tests\Doctrine\Functions
 * @subpackage Somnambulist\Domain\Tests\Doctrine\Functions\TypeFunctionTest
 *
 * @group doctrine
 * @group doctrine-functions
 * @group doctrine-functions-type
 */
class TypeFunctionTest extends TestCase
{

    use BuildDoctrineInstance;

    public function testGetSqlRaisesExceptionIfMissingDiscriminator()
    {
        $this->em->getConfiguration()->addCustomStringFunction('TYPE', TypeFunction::class);

        $this->expectException(Query\QueryException::class);
        $this->expectExceptionMessage('TYPE() only supports entities with a discriminator column.');

        $query = $this->em->createQuery('SELECT TYPE(l) FROM Somnambulist\Domain\Tests\Support\Stubs\Models\Order l');
        $query->getSQL();
    }

    public function testGetSql()
    {
        $this->em->getConfiguration()->addCustomStringFunction('TYPE', TypeFunction::class);

        $query = $this->em->createQuery('SELECT TYPE(a) FROM Somnambulist\Domain\Tests\Support\Stubs\Models\Customer a');
        $sql = $query->getSQL();

        $this->assertEquals("SELECT u0_.type AS sclr_0 FROM users u0_ WHERE u0_.type IN ('customer')", $sql);
    }
}
