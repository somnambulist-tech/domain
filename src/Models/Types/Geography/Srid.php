<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types\Geography;

use Somnambulist\Components\Models\AbstractEnumeration;

/**
 * Represents a Spatial Reference System Identifier
 *
 * This is a unique value for a spatial reference system, see: https://spatialreference.org/ref/epsg/
 * For example: WGS84 has a SRID of 4326; BNG has a SRID of 27700. Only a couple of frequently used
 * references are provided. The EPSG database has over 4000 at the time of writing.
 *
 * @method static Srid BRITISH_NATIONAL_GRID()
 * @method static Srid OSGB1936()
 * @method static Srid WGS84()
 */
final class Srid extends AbstractEnumeration
{
    const BRITISH_NATIONAL_GRID = 27700;
    const OSGB1936              = 27700;
    const WGS84                 = 4326;
}
