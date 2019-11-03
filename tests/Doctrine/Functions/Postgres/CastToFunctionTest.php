<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Doctrine\Functions\Postgres;

use Doctrine\ORM\Query\QueryException;
use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Doctrine\Functions\Postgres\CastToFunction;
use Somnambulist\Domain\Doctrine\Functions\Postgres\IlikeFunction;
use Somnambulist\Domain\Tests\Support\Behaviours\BuildDoctrineInstance;

/**
 * Class CastToFunctionTest
 *
 * @package    Somnambulist\Domain\Tests\Doctrine\Functions\Postgres
 * @subpackage Somnambulist\Domain\Tests\Doctrine\Functions\Postgres\CastToFunctionTest
 * @group functions
 * @group functions-cast
 */
class CastToFunctionTest extends TestCase
{

    use BuildDoctrineInstance;

    public function testGetSql()
    {
        $this->em->getConfiguration()->addCustomStringFunction('CAST', CastToFunction::class);
        $this->em->getConfiguration()->addCustomStringFunction('ILIKE', IlikeFunction::class);

        $query = $this->em
            ->createQuery('SELECT a FROM Somnambulist\Domain\Tests\Doctrine\Entities\Order a WHERE ILIKE(CAST(a.name, \'text\'), :name) = true')
        ;
        $sql = $query->getSQL();

        $this->assertEquals("SELECT o0_.properties AS properties_0, o0_.name AS name_1, o0_.createdAt AS createdAt_2, o0_.id AS id_3, o0_.uuid AS uuid_4, o0_.purchaser_name AS purchaser_name_5, o0_.purchaser_country AS purchaser_country_6, o0_.purchaser_email AS purchaser_email_7, o0_.total_amount AS total_amount_8, o0_.total_currency AS total_currency_9 FROM orders o0_ WHERE o0_.name::text ILIKE ? = 1", $sql);
    }

    public function testGetSqlRaisesExceptionForInvalidCast()
    {
        $this->em->getConfiguration()->addCustomStringFunction('CAST', CastToFunction::class);
        $this->em->getConfiguration()->addCustomStringFunction('ILIKE', IlikeFunction::class);

        $this->expectException(QueryException::class);
        $this->expectExceptionMessage('[Syntax Error] CAST() requires one of "bool, date, float, int, text, time", received "json"');

        $query = $this->em
            ->createQuery('SELECT a FROM Somnambulist\Domain\Tests\Doctrine\Entities\Order a WHERE ILIKE(CAST(a.name, \'json\'), :name) = true')
        ;
        $query->getSQL();
    }
}
