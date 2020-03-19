<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Support\Stubs\Enum;

use Somnambulist\Domain\Entities\AbstractEnumeration;

/**
 * @method static Action CREATE()
 * @method static Action READ()
 * @method static Action UPDATE()
 * @method static Action DELETE()
 */
class Action extends AbstractEnumeration
{
    const CREATE = 'create';
    const READ   = 'read';
    const UPDATE = 'update';
    const DELETE = 'delete';
}
