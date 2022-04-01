<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities\Exceptions;

use Exception;
use function implode;
use function sprintf;

/**
 * Class EntityNotFoundException
 *
 * @package    Somnambulist\Components\Domain\Entities\Exceptions
 * @subpackage Somnambulist\Components\Domain\Entities\Exceptions\EntityNotFoundException
 * @codeCoverageIgnore
 */
class EntityNotFoundException extends Exception
{
    private string $type;
    private string $id;

    /**
     * @param string     $type
     * @param int|string ...$identities
     *
     * @return static
     */
    public static function entityNotFound(string $type, int|string ...$identities): self
    {
        $id = implode(':', $identities);

        $err       = new static(sprintf('Entity "%s" with identifier "%s" not found', $type, $id), 404);
        $err->type = $type;
        $err->id   = $id;

        return $err;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getId(): ?string
    {
        return $this->id;
    }
}
