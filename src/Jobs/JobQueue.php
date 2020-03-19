<?php declare(strict_types=1);

namespace Somnambulist\Domain\Jobs;

/**
 * Interface JobQueue
 *
 * @package    Somnambulist\Domain\Jobs
 * @subpackage Somnambulist\Domain\Jobs\JobQueue
 */
interface JobQueue
{

    public function queue(AbstractJob $job): void;
}
