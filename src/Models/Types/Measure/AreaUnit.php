<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types\Measure;

use Somnambulist\Components\Models\AbstractEnumeration;

/**
 * @method static AreaUnit ACRE()
 * @method static AreaUnit HECTARE()
 *
 * @method static AreaUnit SQ_MM()
 * @method static AreaUnit SQ_CM()
 * @method static AreaUnit SQ_M()
 * @method static AreaUnit SQ_KM()
 * @method static AreaUnit SQ_INCH()
 * @method static AreaUnit SQ_FT()
 * @method static AreaUnit SQ_YARD()
 * @method static AreaUnit SQ_MILE()
 */
final class AreaUnit extends AbstractEnumeration
{
    const ACRE    = 'ac';
    const HECTARE = 'ha';

    const SQ_MM   = 'sq_mm';
    const SQ_CM   = 'sq_cm';
    const SQ_M    = 'sq_m';
    const SQ_KM   = 'sq_km';
    const SQ_INCH = 'sq_in';
    const SQ_FT   = 'sq_ft';
    const SQ_YARD = 'sq_yd';
    const SQ_MILE = 'sq_mi';
}
