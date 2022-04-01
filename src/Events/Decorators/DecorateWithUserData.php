<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Events\Decorators;

use Somnambulist\Components\Domain\Events\AbstractEvent;
use Symfony\Component\Security\Core\Security;
use function method_exists;

/**
 * Class DecorateWithUserData
 *
 * @package    Somnambulist\Components\Domain\Events\Decorators
 * @subpackage Somnambulist\Components\Domain\Events\Decorators\DecorateWithUserData
 */
class DecorateWithUserData implements EventDecoratorInterface
{
    public function __construct(private Security $security)
    {
    }

    public function decorate(AbstractEvent $event): AbstractEvent
    {
        if (null === $user = $this->security->getUser()) {
            $event->appendContext(['user' => ['id' => null, 'name' => 'unauthenticated', 'roles' => []]]);

            return $event;
        }

        $event->appendContext([
            'user' => [
                'id'    => method_exists($user, 'getId') ? (string)$user->getId() : null,
                'name'  => $user->getUsername(),
                'roles' => $user->getRoles(),
            ],
        ]);

        return $event;
    }
}
