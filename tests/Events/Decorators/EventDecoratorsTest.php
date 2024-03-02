<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Events\Decorators;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Events\AbstractEvent;
use Somnambulist\Components\Events\Decorators\DecorateWithRequestId;
use Somnambulist\Components\Events\Decorators\DecorateWithUserData;
use Somnambulist\Components\Events\Publishers\MessengerEventPublisher;
use Somnambulist\Components\Models\Types\DateTime\DateTime;
use Somnambulist\Components\Models\Types\Identity\Uuid;
use Somnambulist\Components\Tests\Support\Stubs\EventListeners\AssertingEventBus;
use Somnambulist\Components\Tests\Support\Stubs\Models\MyEntity;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;

class EventDecoratorsTest extends TestCase
{

    private MessengerEventPublisher $dispatcher;

    protected function setUp(): void
    {
        $this->dispatcher = new MessengerEventPublisher(new AssertingEventBus([
            'my_entity_created' => $c = function (AbstractEvent $event) {
                $this->assertArrayHasKey('request_id', $event->context()->toArray());
                $this->assertEquals('98e2929d-b861-456f-9026-4afe7e3f1e23', $event->context()->get('request_id'));
                $this->assertArrayHasKey('user', $event->context()->toArray());
                $this->assertArrayHasKey('id', $event->context()->toArray()['user']);
                $this->assertArrayHasKey('name', $event->context()->toArray()['user']);
                $this->assertEquals('4fad6b95-34c1-47fd-971d-9deb9f8fa2c4', $event->context()->get('user.id'));
            },
            'my_entity_added_another_entity' => $c,
        ]), [
            new DecorateWithRequestId($stack = new RequestStack()),
            new DecorateWithUserData(new Security($container = new Container())),
        ]);

        $request = Request::createFromGlobals();
        $request->headers->set('X-Request-Id', '98e2929d-b861-456f-9026-4afe7e3f1e23');

        $stack->push($request);

        $container->set('security.token_storage', new class {
            public function getToken(): UsernamePasswordToken
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

                    public function getUsername(): string
                    {
                        return 'foo@bar.com';
                    }

                    public function eraseCredentials(): void
                    {

                    }

                    public function getId(): string
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
