<?php declare(strict_types=1);

namespace Somnambulist\Components\Events\Decorators;

use Somnambulist\Components\Events\AbstractEvent;
use Somnambulist\Components\Events\EventDecoratorInterface;
use Symfony\Component\Security\Core\Security;
use function method_exists;

class DecorateWithUserData implements EventDecoratorInterface
{
    public function __construct(private Security $security)
    {
    }

    public function decorate(AbstractEvent $event): AbstractEvent
    {
        if (null === $user = $this->security->getUser()) {
            return $event->appendContext(['user' => ['id' => null, 'name' => 'unauthenticated', 'roles' => []]]);
        }

        return $event->appendContext([
            'user' => [
                'id'    => method_exists($user, 'getId') ? (string)$user->getId() : null,
                'name'  => $user->getUserIdentifier(),
                'roles' => $user->getRoles(),
            ],
        ]);
    }
}
