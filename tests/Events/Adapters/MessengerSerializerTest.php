<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Events\Adapters;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Events\Adapters\MessengerSerializer;
use Somnambulist\Components\Tests\Support\Stubs\Events\NamespacedEvent;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\BusNameStamp;
use Symfony\Component\Messenger\Stamp\TransportMessageIdStamp;
use function define;
use function defined;

/**
 * @group events
 * @group events-adapter
 * @group events-adapter-serializer
 * @todo remove
 */
class MessengerSerializerTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        if (!defined('AMQP_NOPARAM')) {
            define('AMQP_NOPARAM', 0);
        }
    }

    public function testDecode()
    {
        $payload = [
            'body'    => '{"aggregate":{"class":null,"id":null},"event":{"class":"Somnambulist\\\\Tests\\\\Support\\\\Stubs\\\\Events\\\\NamespacedEvent","name":"app.namespaced","version":2,"time":1571844439.726061},"context":{"context":"value","user":"user@example.example"},"payload":{"foo":"bar"}}',
            'headers' =>
                [
                    'type'         => 'Somnambulist\\Components\\Tests\\Support\\Stubs\\Events\\NamespacedEvent',
                    'Content-Type' => 'application/json',
                ],
        ];

        $serializer = MessengerSerializer::create();

        $envelope = $serializer->decode($payload);
        $event = $envelope->getMessage();

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertEquals(NamespacedEvent::class, $event->type());
        $this->assertEquals(1571844439.726061, $event->createdAt());
        $this->assertEquals('app', $event->group());
        $this->assertEquals('namespaced', $event->name());
    }

    public function testEncode()
    {
        $event = NamespacedEvent::create(['foo' => 'bar'], ['context' => 'value', 'user' => 'user@example.example']);

        $serializer = MessengerSerializer::create();

        $message = $serializer->encode(
            new Envelope(
                $event,
                [new AmqpStamp($event->longName())]
            )
        );

        $this->assertIsArray($message);
        $this->assertArrayHasKey('body', $message);
        $this->assertArrayHasKey('headers', $message);
        $this->assertEquals('application/json', $message['headers']['Content-Type']);
    }

    public function testEncodeWithMultipleStamps()
    {
        $event = NamespacedEvent::create(['foo' => 'bar'], ['context' => 'value', 'user' => 'user@example.example']);

        $serializer = MessengerSerializer::create();

        $message = $serializer->encode(
            new Envelope(
                $event,
                [
                    new AmqpStamp($event->longName()),
                    new BusNameStamp('eventBus'),
                    new TransportMessageIdStamp('my-id-here'),
                ]
            )
        );

        $this->assertIsArray($message);
        $this->assertArrayHasKey('body', $message);
        $this->assertArrayHasKey('headers', $message);

        $this->assertArrayHasKey('X-Message-Stamp-Symfony\Component\Messenger\Stamp\BusNameStamp', $message['headers']);
        $this->assertArrayHasKey('X-Message-Stamp-Symfony\Component\Messenger\Stamp\TransportMessageIdStamp', $message['headers']);

        $this->assertEquals('application/json', $message['headers']['Content-Type']);
        $this->assertEquals('[{"busName":"eventBus"}]', $message['headers']['X-Message-Stamp-Symfony\Component\Messenger\Stamp\BusNameStamp']);
        $this->assertEquals('[{"id":"my-id-here"}]', $message['headers']['X-Message-Stamp-Symfony\Component\Messenger\Stamp\TransportMessageIdStamp']);
    }
}
