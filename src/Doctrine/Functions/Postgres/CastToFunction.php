<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Doctrine\Functions\Postgres;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\Query\SqlWalker;
use IlluminateAgnostic\Str\Support\Str;

/**
 * Class CastToFunction
 *
 * Postgres simple casting: CAST(<field>, '<type>') ::= <field>::<type>
 *
 * @package    Somnambulist\Components\Domain\Doctrine
 * @subpackage Somnambulist\Components\Domain\Doctrine\Functions\Postgres
 */
class CastToFunction extends FunctionNode
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

        $this->value = Str::ascii($parser->StringPrimary()->value);

        $casts = ['bool', 'date', 'float', 'int', 'text', 'time',];

        if (!in_array($this->value, $casts)) {
            throw QueryException::syntaxError(
                sprintf('CAST() requires one of "%s", received "%s"', implode(', ', $casts), $this->value)
            );
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return $this->field->dispatch($sqlWalker) . '::' . $this->value;
    }
}
