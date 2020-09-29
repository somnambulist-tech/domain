<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities\Types\Web;

use Assert\Assert;
use Somnambulist\Components\Domain\Entities\AbstractValueObject;

/**
 * Class Url
 *
 * @package    Somnambulist\Components\Domain\Entities\Types\Web
 * @subpackage Somnambulist\Components\Domain\Entities\Types\Web\Url
 */
final class Url extends AbstractValueObject
{

    private string $value;

    public function __construct($url)
    {
        Assert::that($url, null, 'url')->notEmpty()->url();

        $this->value = $url;
    }

    public function toString(): string
    {
        return (string)$this->value;
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
