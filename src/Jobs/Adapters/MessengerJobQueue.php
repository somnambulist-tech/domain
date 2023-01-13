<?php declare(strict_types=1);

namespace Somnambulist\Components\Jobs\Adapters;

use Somnambulist\Components\Jobs\AbstractJob;
use Somnambulist\Components\Jobs\JobQueue;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerJobQueue implements JobQueue
{
    public function __construct(private readonly MessageBusInterface $jobQueue)
    {
    }

    public function queue(AbstractJob $job): void
    {
        $this->jobQueue->dispatch($job);
    }
}
