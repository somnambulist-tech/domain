<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Functions\Postgres;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * Postgres replace function: REPLACE(<field>, '<search>', '<replace>') ::= <field>::<search>::<replace>
 *
 * Originally by:
 * @author Jarek Kostrz <jkostrz@gmail.com>
 * @link https://github.com/beberlei/DoctrineExtensions/blob/master/src/Query/Mysql/Replace.php
 *
 * Adapted for Postgres.
 */
class ReplaceFunction extends FunctionNode
{
    protected mixed $search  = null;
    protected mixed $replace = null;
    protected mixed $subject = null;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->subject = $parser->ArithmeticPrimary();

        $parser->match(TokenType::T_COMMA);

        $this->search = $parser->ArithmeticPrimary();

        $parser->match(TokenType::T_COMMA);

        $this->replace = $parser->ArithmeticPrimary();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return
            'REPLACE(' .
            $this->subject->dispatch($sqlWalker) . ', ' .
            $this->search->dispatch($sqlWalker) . ', ' .
            $this->replace->dispatch($sqlWalker) .
            ')'
        ;
    }
}
