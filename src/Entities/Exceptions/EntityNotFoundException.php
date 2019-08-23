<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Exceptions;

use Exception;
use function sprintf;

/**
 * Class EntityNotFoundException
 *
 * @package    Somnambulist\Domain\Entities\Exceptions
 * @subpackage Somnambulist\Domain\Entities\Exceptions\EntityNotFoundException
 * @codeCoverageIgnore
 */
class EntityNotFoundException extends Exception
{

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $id;

    /**
     * @param string          $type
     * @param null|int|string $id
     *
     * @return EntityNotFoundException
     */
    public static function entityNotFound($type, $id = null): self
    {
        $err       = new static(sprintf('Entity "%s" with identifier "%s" not found', $type, $id), 404);
        $err->type = $type;
        $err->id   = $id;

        return $err;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }
}
