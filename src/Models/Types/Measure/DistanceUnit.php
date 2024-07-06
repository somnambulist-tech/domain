<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types\Measure;

use Somnambulist\Components\Models\Contracts\CanTestEquality;

enum DistanceUnit: string implements CanTestEquality
{
    case MILLIMETRE = 'mm';
    case CENTIMETRE = 'cm';
    case METRE      = 'm';
    case KM         = 'km';

    case INCH       = 'in';
    case FEET       = 'ft';
    case YARD       = 'yd';
    case MILE       = 'mi';

    public function equals(object $object): bool
    {
        return $this === $object;
    }
}
