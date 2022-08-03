<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Exceptions;

use Exception;
use function implode;
use function sprintf;

/**
 * @codeCoverageIgnore
 */
class EntityNotFoundException extends Exception
{
    private readonly string $type;
    private readonly string $id;

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
