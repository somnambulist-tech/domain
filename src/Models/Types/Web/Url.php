<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types\Web;

use Assert\Assert;
use Somnambulist\Components\Models\AbstractValueObject;

/**
 * Represents a URL in the domain
 */
final readonly class Url extends AbstractValueObject
{
    public function __construct(private string $value)
    {
        Assert::that($value, null, 'url')->notEmpty()->url();
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function scheme(): string
    {
        return $this->parseString(PHP_URL_SCHEME);
    }

    public function host(): string
    {
        return $this->parseString(PHP_URL_HOST);
    }

    public function port(): string
    {
        return $this->parseString(PHP_URL_PORT);
    }

    public function user(): string
    {
        return $this->parseString(PHP_URL_USER);
    }

    public function password(): string
    {
        return $this->parseString(PHP_URL_PASS);
    }

    public function path(): string
    {
        return $this->parseString(PHP_URL_PATH);
    }

    public function query(): string
    {
        return $this->parseString(PHP_URL_QUERY);
    }

    public function fragment(): string
    {
        return $this->parseString(PHP_URL_FRAGMENT);
    }

    private function parseString(int $component): string
    {
        return (string)parse_url($this->value, $component);
    }
}
