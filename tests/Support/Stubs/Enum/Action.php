<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Support\Stubs\Enum;

use Somnambulist\Components\Models\AbstractEnumeration;

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
