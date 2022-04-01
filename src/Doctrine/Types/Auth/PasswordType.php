<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Doctrine\Types\Auth;

use Somnambulist\Components\Domain\Doctrine\Types\AbstractValueObjectType;
use Somnambulist\Components\Domain\Entities\Types\Auth\Password;

/**
 * Class PasswordType
 *
 * @package    Somnambulist\Components\Domain\Doctrine\Types\Auth
 * @subpackage Somnambulist\Components\Domain\Doctrine\Types\Auth\PasswordType
 */
class PasswordType extends AbstractValueObjectType
{
    protected string $name = 'password';
    protected string $class = Password::class;
}
