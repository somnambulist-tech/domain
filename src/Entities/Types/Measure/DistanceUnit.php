<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types\Measure;

use Somnambulist\Domain\Entities\AbstractEnumeration;

/**
 * Class DistanceUnit
 *
 * @package    Somnambulist\Domain\Entities\Types\Measure
 * @subpackage Somnambulist\Domain\Entities\Types\Measure\DistanceUnit
 *
 * @method static DistanceUnit FEET()
 * @method static DistanceUnit KM()
 * @method static DistanceUnit METRE()
 * @method static DistanceUnit MILE()
 * @method static DistanceUnit YARD()
 */
final class DistanceUnit extends AbstractEnumeration
{

    const FEET  = 'ft';
    const KM    = 'km';
    const METRE = 'm';
    const MILE  = 'mi';
    const YARD  = 'yd';

}
