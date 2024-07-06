<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types\Measure;

use Somnambulist\Components\Models\Contracts\CanTestEquality;

enum AreaUnit: string implements CanTestEquality
{
    case ACRE    = 'ac';
    case HECTARE = 'ha';

    case SQ_MM   = 'sq_mm';
    case SQ_CM   = 'sq_cm';
    case SQ_M    = 'sq_m';
    case SQ_KM   = 'sq_km';
    case SQ_INCH = 'sq_in';
    case SQ_FT   = 'sq_ft';
    case SQ_YARD = 'sq_yd';
    case SQ_MILE = 'sq_mi';

    public function equals(object $object): bool
    {
        return $this === $object;
    }
}
