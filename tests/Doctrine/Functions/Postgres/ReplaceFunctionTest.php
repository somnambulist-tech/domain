<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Doctrine\Functions\Postgres;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Domain\Doctrine\Functions\Postgres\ReplaceFunction;
use Somnambulist\Components\Domain\Tests\Support\Behaviours\BuildDoctrineInstance;

/**
 * Class ReplaceFunctionTest
 *
 * @package    Somnambulist\Components\Domain\Tests\Doctrine\Functions\Postgres
 * @subpackage Somnambulist\Components\Domain\Tests\Doctrine\Functions\Postgres\ReplaceFunctionTest
 *
 * @group doctrine
 * @group doctrine-functions
 * @group doctrine-functions-replace
 */
class ReplaceFunctionTest extends TestCase
{

    use BuildDoctrineInstance;

    public function testGetSql()
    {
        $this->em->getConfiguration()->addCustomStringFunction('REPLACE', ReplaceFunction::class);

        $query = $this->em
            ->createQuery('SELECT a FROM Somnambulist\Components\Domain\Tests\Support\Stubs\Models\Order a WHERE REPLACE(a.name, \'bob\', \'sally\') = true')
        ;
        $sql = $query->getSQL();

        $this->assertEquals("SELECT o0_.properties AS properties_0, o0_.name AS name_1, o0_.createdAt AS createdAt_2, o0_.id AS id_3, o0_.uuid AS uuid_4, o0_.purchaser_name AS purchaser_name_5, o0_.purchaser_country AS purchaser_country_6, o0_.purchaser_email AS purchaser_email_7, o0_.total_amount AS total_amount_8, o0_.total_currency AS total_currency_9 FROM orders o0_ WHERE REPLACE(o0_.name, 'bob', 'sally') = 1", $sql);
    }
}
