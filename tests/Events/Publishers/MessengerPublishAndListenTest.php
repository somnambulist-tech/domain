<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Events\Publishers;

use PHPUnit\Framework\Assert;
use Somnambulist\Components\Events\EventBus;
use Somnambulist\Components\Models\Types\Identity\Aggregate;
use Somnambulist\Components\Tests\Support\Behaviours\BootKernel;
use Somnambulist\Components\Tests\Support\Stubs\Events\RequeuableEvent;
use Somnambulist\Components\Tests\Support\Stubs\Events\UserCreated;
use Somnambulist\Components\Tests\Support\Stubs\Models\User;
use Somnambulist\Components\Utils\EntityAccessor;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpTransport;
use function extension_loaded;

/**
 * Tests that domain events can be successfully re-queued in the event of failure, including
 * backing off. Only run locally as it requires AMQP to properly test.
 *
 * @group amqp
 */
class MessengerPublishAndListenTest extends KernelTestCase
{
    use BootKernel;

    public static function setUpBeforeClass(): void
    {
        if (!extension_loaded('amqp')) {
            Assert::markTestSkipped('amqp extension is not loaded');
        }
    }

    private function clearQueue(): void
    {
        /** @var AmqpTransport $bus */
        $bus = static::getContainer()->get('messenger.transport.domain_events');

        $conn = EntityAccessor::get($bus, 'connection', $bus);
        $conn->purgeQueues();
    }

    public function testFireAndListenForEvent()
    {
        $this->clearQueue();

        $bus = static::getContainer()->get(EventBus::class);
        $bus->notify(new UserCreated(aggregate: new Aggregate(User::class, 'd4cf15ba-3fc7-436a-ac48-5a8d4ecd3355')));

        $application = new Application(static::$kernel);

        $command = $application->find('messenger:consume');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            // pass arguments to the helper
            'receivers' => ['domain_events'],

            // prefix the key with two dashes when passing options,
            // e.g: '--some-option' => 'option_value',
            '--limit' => 1,
            '--verbose' => 1,
        ]);

        $commandTester->assertCommandIsSuccessful();

        /** @var AmqpTransport $bus */
        $bus = static::getContainer()->get('messenger.transport.domain_events');
        $this->assertEquals(0, $bus->getMessageCount());
    }

    public function testRequeueEvents()
    {
        $bus = static::getContainer()->get(EventBus::class);
        $bus->notify(new RequeuableEvent(aggregate: new Aggregate(User::class, 'd4cf15ba-3fc7-436a-ac48-5a8d4ecd3355')));

        $application = new Application(static::$kernel);

        $command = $application->find('messenger:consume');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'receivers' => ['domain_events'],
            '--limit' => 1,
        ]);

        $commandTester->assertCommandIsSuccessful();

        sleep(2);

        /** @var AmqpTransport $bus */
        $bus = static::getContainer()->get('messenger.transport.domain_events');
        $this->assertEquals(1, $bus->getMessageCount());
    }

    /**
     * @depends testRequeueEvents
     */
    public function testRequeueReprocess()
    {
        $application = new Application(static::$kernel);

        $command = $application->find('messenger:consume');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'receivers' => ['domain_events'],
            // message failures add increasing re-try time breaks
            '--time-limit' => 10,
        ]);

        $commandTester->assertCommandIsSuccessful();

        /** @var AmqpTransport $bus */
        $bus = static::getContainer()->get('messenger.transport.domain_events');

        // using default retries the queue should be empty now, since it failed processing once already
        $this->assertEquals(0, $bus->getMessageCount());
    }
}
