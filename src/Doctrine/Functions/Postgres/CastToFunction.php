<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Functions\Postgres;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;
use function Symfony\Component\String\u;

/**
 * Postgres simple casting: CAST(<field>, '<type>') ::= <field>::<type>
 */
class CastToFunction extends FunctionNode
{
    protected mixed $field;
    protected mixed $value;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->field = $parser->StringExpression();

        $parser->match(TokenType::T_COMMA);

        $this->value = u($parser->StringPrimary()->value)->ascii();

        $casts = ['bool', 'date', 'float', 'int', 'text', 'time',];

        if (!in_array($this->value, $casts)) {
            throw QueryException::syntaxError(
                sprintf('CAST() requires one of "%s", received "%s"', implode(', ', $casts), $this->value)
            );
        }

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return $this->field->dispatch($sqlWalker) . '::' . $this->value;
    }
}
