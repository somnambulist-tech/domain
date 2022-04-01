<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Jobs\Adapters;

use Somnambulist\Components\Domain\Jobs\AbstractJob;
use Somnambulist\Components\Domain\Jobs\JobQueue;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class MessengerJobQueue
 *
 * @package    Somnambulist\Components\Domain\Jobs\Adapters
 * @subpackage Somnambulist\Components\Domain\Jobs\Adapters\MessengerJobQueue
 */
final class MessengerJobQueue implements JobQueue
{
    public function __construct(private MessageBusInterface $jobQueue)
    {
    }

    public function queue(AbstractJob $job): void
    {
        $this->jobQueue->dispatch($job);
    }
}
