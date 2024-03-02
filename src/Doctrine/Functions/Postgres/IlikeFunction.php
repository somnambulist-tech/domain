<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Functions\Postgres;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

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
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->field = $parser->StringExpression();

        $parser->match(TokenType::T_COMMA);

        $this->value = $parser->StringPrimary();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return $this->field->dispatch($sqlWalker) . ' ILIKE ' . $this->value->dispatch($sqlWalker);
    }
}
