<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Doctrine\Functions\Postgres;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * Class IlikeFunction
 *
 * @link https://github.com/fabiofumarola/edb/blob/master/src/Kdde/EdbBundle/DQL/ILIKE.php
 *
 * @package    Somnambulist\Components\Domain\Doctrine
 * @subpackage Somnambulist\Components\Domain\Doctrine\Functions\Postgres
 */
class IlikeFunction extends FunctionNode
{
    /**
     * @var Node
     */
    protected $field;

    /**
     * @var Node
     */
    protected $value;

    public function parse(Parser $parser): void
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->field = $parser->StringExpression();

        $parser->match(Lexer::T_COMMA);

        $this->value = $parser->StringPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return $this->field->dispatch($sqlWalker) . ' ILIKE ' . $this->value->dispatch($sqlWalker);
    }
}
