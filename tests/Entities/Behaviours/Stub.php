<?php

declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Entities\Behaviours;

use Somnambulist\Domain\Entities\Behaviours;

/**
 * Class Stub
 *
 * @package    Somnambulist\Domain\Tests\Entities\Behaviours
 * @subpackage Somnambulist\Domain\Tests\Entities\Behaviours\Stub
 */
class Stub
{

    use Behaviours\Nameable;
    use Behaviours\NumericallySortable;
    use Behaviours\Timestampable;
    use Behaviours\Stringable;
    use Behaviours\Versionable;

}
