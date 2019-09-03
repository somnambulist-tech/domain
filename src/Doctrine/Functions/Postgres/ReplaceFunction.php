<?php declare(strict_types=1);

namespace Somnambulist\Domain\Doctrine\Functions\Postgres;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * Class ReplaceFunction
 *
 * Postgres replace function: REPLACE(<field>, '<search>', '<replace>') ::= <field>::<search>::<replace>
 *
 * Originally by:
 * @author Jarek Kostrz <jkostrz@gmail.com>
 * @link https://github.com/beberlei/DoctrineExtensions/blob/master/src/Query/Mysql/Replace.php
 *
 * Adapted for Postgres.
 *
 * @package    Somnambulist\Domain\Doctrine
 * @subpackage Somnambulist\Domain\Doctrine\Functions\Postgres
 */
class ReplaceFunction extends FunctionNode
{
    protected $search  = null;
    protected $replace = null;
    protected $subject = null;

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->subject = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_COMMA);

        $this->search = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_COMMA);

        $this->replace = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker)
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
