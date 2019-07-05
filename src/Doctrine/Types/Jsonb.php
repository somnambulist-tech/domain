<?php declare(strict_types=1);

namespace Somnambulist\Domain\Doctrine\Types;

/**
 * Class Jsonb
 *
 * @package    Somnambulist\Domain\Doctrine\Types
 * @subpackage Somnambulist\Domain\Doctrine\Types\Jsonb
 */
class Jsonb extends JsonCollectionType
{

    /**
     * @var string
     */
    const TYPE_NAME = 'jsonb';

}
