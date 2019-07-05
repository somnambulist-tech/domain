<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types\Geography;

use Somnambulist\Domain\Entities\AbstractEnumeration;

/**
 * Class Srid
 *
 * Represents a Spatial Reference System Identifier - a unique value for a spatial reference system.
 * For example: WGS84 has a SRID of 4326; BNG has a SRID of 27700.
 *
 * @package    Somnambulist\Domain\Entities\Types\Geography
 * @subpackage Somnambulist\Domain\Entities\Types\Geography\Srid
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
