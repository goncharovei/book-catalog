<?php

namespace App\Front\Publisher\Jobs;

use App\Common\Models\Publisher;
use App\Front\Publisher\Service\PublisherToken\PublisherTokenService;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class PublisherTokenCreateJob implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private Publisher $publisher)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(PublisherTokenService $tokenService): void
    {
        $tokenService->setDependencies($this->publisher)->create();
    }
}
