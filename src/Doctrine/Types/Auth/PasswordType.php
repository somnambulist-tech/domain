<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine\Types\Auth;

use Somnambulist\Components\Doctrine\Types\AbstractValueObjectType;
use Somnambulist\Components\Models\Types\Auth\Password;

/**
 * Allows using Password instances as types instead of embeddables
 */
class PasswordType extends AbstractValueObjectType
{
    protected string $name = 'password';
    protected string $class = Password::class;
}
