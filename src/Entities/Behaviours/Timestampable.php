<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Traits;

use Somnambulist\Domain\Entities\Types\DateTime\DateTime;

/**
 * Trait Timestampable
 *
 * @package    Somnambulist\Domain\Entities\Traits
 * @subpackage Somnambulist\Domain\Entities\Traits\Timestampable
 */
trait Timestampable
{

    /**
     * @var DateTime
     */
    protected $createdAt;

    /**
     * @var DateTime
     */
    protected $updatedAt;

    public function initializeTimestamps(): void
    {
        if (!$this->createdAt && !$this->updatedAt) {
            $this->createdAt = DateTime::now();
            $this->updatedAt = DateTime::now();
        }
    }

    public function updateTimestamps(): void
    {
        $this->updatedAt = DateTime::now();
    }
}
