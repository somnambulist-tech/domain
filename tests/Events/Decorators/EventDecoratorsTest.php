<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Events\Decorators;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Domain\Entities\Types\DateTime\DateTime;
use Somnambulist\Components\Domain\Entities\Types\Identity\Uuid;
use Somnambulist\Components\Domain\Events\AbstractEvent;
use Somnambulist\Components\Domain\Events\Decorators\DecorateWithRequestId;
use Somnambulist\Components\Domain\Events\Decorators\DecorateWithUserData;
use Somnambulist\Components\Domain\Events\Publishers\MessengerEventPublisher;
use Somnambulist\Components\Domain\Tests\Support\Stubs\EventListeners\AssertingEventBus;
use Somnambulist\Components\Domain\Tests\Support\Stubs\Models\MyEntity;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class EventDecoratorsTest
 *
 * @package    Somnambulist\Components\Domain\Tests\Events\Decorators
 * @subpackage Somnambulist\Components\Domain\Tests\Events\Decorators\EventDecoratorsTest
 */
class EventDecoratorsTest extends TestCase
{

    private MessengerEventPublisher $dispatcher;

    protected function setUp(): void
    {
        $this->dispatcher = new MessengerEventPublisher(new AssertingEventBus([
            'MyEntityCreated' => $c = function (AbstractEvent $event) {
                $this->assertArrayHasKey('request_id', $event->context()->toArray());
                $this->assertEquals('98e2929d-b861-456f-9026-4afe7e3f1e23', $event->context()->get('request_id'));
                $this->assertArrayHasKey('user', $event->context()->toArray());
                $this->assertArrayHasKey('id', $event->context()->toArray()['user']);
                $this->assertArrayHasKey('name', $event->context()->toArray()['user']);
                $this->assertEquals('4fad6b95-34c1-47fd-971d-9deb9f8fa2c4', $event->context()->get('user.id'));
            },
            'MyEntityAddedAnotherEntity' => $c,
        ]), [
            new DecorateWithRequestId($stack = new RequestStack()),
            new DecorateWithUserData(new Security($container = new Container())),
        ]);

        $request = Request::createFromGlobals();
        $request->headers->set('X-Request-Id', '98e2929d-b861-456f-9026-4afe7e3f1e23');

        $stack->push($request);

        $container->set('security.token_storage', new class {
            public function getToken()
            {
                return new UsernamePasswordToken(new class implements UserInterface {
                    public function getRoles(): array
                    {
                        return ['ROLE_USER', 'ROLE_MODERATOR'];
                    }

                    public function getPassword()
                    {
                        return null;
                    }

                    public function getSalt()
                    {
                        return null;
                    }

                    public function getUserIdentifier(): string
                    {
                        return $this->getUsername();
                    }

                    public function getUsername()
                    {
                        return 'foo@bar.com';
                    }

                    public function eraseCredentials()
                    {

                    }

                    public function getId()
                    {
                        return '4fad6b95-34c1-47fd-971d-9deb9f8fa2c4';
                    }
                }, 'user', ['provider']);
            }
        });
    }

    public function testInjectRequestId()
    {
        $entity = new MyEntity(new Uuid('e9177266-5a64-420d-afda-04feb7edf14d'), 'test', 'bob');

        $this->dispatcher->publishEventsFrom($entity);
        $this->dispatcher->dispatch();
    }

    public function testInjectUserData()
    {
        $entity = new MyEntity(new Uuid('e9177266-5a64-420d-afda-04feb7edf14d'), 'test', 'bob');

        $this->dispatcher->publishEventsFrom($entity);
        $this->dispatcher->dispatch();
    }

    public function testMultipleEvents()
    {
        $entity = new MyEntity(new Uuid('e9177266-5a64-420d-afda-04feb7edf14d'), 'test', 'bob');
        $entity->addRelated('foo', 'bar', DateTime::now());
        $entity->addRelated('foo', 'bar', DateTime::now());

        $this->dispatcher->publishEventsFrom($entity);
        $this->dispatcher->dispatch();
    }
}
