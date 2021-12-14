<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Jobs;

/**
 * Interface JobQueue
 *
 * @package    Somnambulist\Components\Domain\Jobs
 * @subpackage Somnambulist\Components\Domain\Jobs\JobQueue
 */
interface JobQueue
{
    public function queue(AbstractJob $job): void;
}
