<?php declare(strict_types=1);

namespace Somnambulist\Domain\Jobs\Adapters;

use Somnambulist\Domain\Jobs\AbstractJob;
use Somnambulist\Domain\Jobs\JobQueue;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class MessengerJobQueue
 *
 * @package    Somnambulist\Domain\Jobs\Adapters
 * @subpackage Somnambulist\Domain\Jobs\Adapters\MessengerJobQueue
 */
final class MessengerJobQueue implements JobQueue
{

    private MessageBusInterface $jobQueue;

    public function __construct(MessageBusInterface $jobQueue)
    {
        $this->jobQueue = $jobQueue;
    }

    public function queue(AbstractJob $job): void
    {
        $this->jobQueue->dispatch($job);
    }
}
