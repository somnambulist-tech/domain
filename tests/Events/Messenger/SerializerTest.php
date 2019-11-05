<?php declare(strict_types=1);

namespace Somnambulist\Domain\Tests\Events\Messenger;

use Events\NamespacedEvent;
use PHPUnit\Framework\TestCase;
use Somnambulist\Domain\Events\Messenger\Serializer;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\BusNameStamp;
use Symfony\Component\Messenger\Stamp\TransportMessageIdStamp;
use Symfony\Component\Messenger\Transport\AmqpExt\AmqpStamp;
use function defined;

/**
 * Class SerializerTest
 *
 * @package Somnambulist\Domain\Tests\Events\Messenger
 * @subpackage Somnambulist\Domain\Tests\Events\Messenger\SerializerTest
 */
class SerializerTest extends TestCase
{

    public static function setUpBeforeClass(): void
    {
        if (!defined('AMQP_NOPARAM')) {
            define('AMQP_NOPARAM', 0);
        }
    }

    /**
     * @group domain-event-serializer
     */
    public function testDecode()
    {
        $payload = [
            'body'    => '{"aggregate":{"class":null,"id":null},"event":{"class":"Events\\\\NamespacedEvent","name":"app.namespaced","version":2,"time":1571844439.726061},"context":{"context":"value","user":"user@example.example"},"payload":{"foo":"bar"}}',
            'headers' =>
                [
                    'type'         => 'Events\\NamespacedEvent',
                    'Content-Type' => 'application/json',
                ],
        ];

        $serializer = Serializer::create();

        $envelope = $serializer->decode($payload);
        $event = $envelope->getMessage();

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertInstanceOf(NamespacedEvent::class, $event);
        $this->assertEquals(2, $event->version());
        $this->assertEquals(1571844439.726061, $event->time());
    }

    /**
     * @group domain-event-serializer
     */
    public function testEncode()
    {
        $event = NamespacedEvent::create(['foo' => 'bar'], ['context' => 'value', 'user' => 'user@example.example'], 2);

        $serializer = Serializer::create();

        $message = $serializer->encode(
            new Envelope(
                $event,
                [new AmqpStamp($event->notificationName())]
            )
        );

        $this->assertIsArray($message);
        $this->assertArrayHasKey('body', $message);
        $this->assertArrayHasKey('headers', $message);
        $this->assertEquals('application/json', $message['headers']['Content-Type']);
    }

    /**
     * @group domain-event-serializer
     */
    public function testEncodeWithMultipleStamps()
    {
        $event = NamespacedEvent::create(['foo' => 'bar'], ['context' => 'value', 'user' => 'user@example.example'], 2);

        $serializer = Serializer::create();

        $message = $serializer->encode(
            new Envelope(
                $event,
                [
                    new AmqpStamp($event->notificationName()),
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
