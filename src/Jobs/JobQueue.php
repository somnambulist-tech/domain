<?php declare(strict_types=1);

namespace Somnambulist\Components\Jobs;

interface JobQueue
{
    public function queue(AbstractJob $job): void;
}
