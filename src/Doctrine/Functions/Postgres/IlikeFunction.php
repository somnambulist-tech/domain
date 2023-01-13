<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Functions\Postgres;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * MathTextFunction ::= "ILIKE" "(" StringPrimary "," StringPrimary ")"
 *
 * Originally from:
 * @link https://github.com/fabiofumarola/edb/blob/master/src/Kdde/EdbBundle/DQL/ILIKE.php
 */
class IlikeFunction extends FunctionNode
{
    protected mixed $field;
    protected mixed $value;

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
