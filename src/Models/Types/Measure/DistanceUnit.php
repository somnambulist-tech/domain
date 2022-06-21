<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types\Measure;

use Somnambulist\Components\Models\AbstractEnumeration;

/**
 * @method static DistanceUnit MILLIMETRE()
 * @method static DistanceUnit CENTIMETRE()
 * @method static DistanceUnit METRE()
 * @method static DistanceUnit KM()
 *
 * @method static DistanceUnit INCH()
 * @method static DistanceUnit FEET()
 * @method static DistanceUnit YARD()
 * @method static DistanceUnit MILE()
 */
final class DistanceUnit extends AbstractEnumeration
{
    const MILLIMETRE = 'mm';
    const CENTIMETRE = 'cm';
    const METRE      = 'm';
    const KM         = 'km';

    const INCH       = 'in';
    const FEET       = 'ft';
    const YARD       = 'yd';
    const MILE       = 'mi';
}
