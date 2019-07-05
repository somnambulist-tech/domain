<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types\Measure;

use Somnambulist\Domain\Entities\AbstractEnumeration;

/**
 * Class AreaUnit
 *
 * @package    Somnambulist\Domain\Entities\Types\Measure
 * @subpackage Somnambulist\Domain\Entities\Types\Measure\AreaUnit
 *
 * @method static AreaUnit SQ_M()
 * @method static AreaUnit SQ_FT()
 * @method static AreaUnit SQ_YARD()
 * @method static AreaUnit ACRE()
 * @method static AreaUnit HECTARE()
 */
final class AreaUnit extends AbstractEnumeration
{

    const ACRE    = 'ac';
    const HECTARE = 'ha';
    const SQ_M    = 'sq_m';
    const SQ_FT   = 'sq_ft';
    const SQ_YARD = 'sq_yd';

}
