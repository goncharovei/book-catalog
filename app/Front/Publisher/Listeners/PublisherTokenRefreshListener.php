<?php

namespace App\Front\Publisher\Listeners;

use App\Front\Publisher\Events\PublisherTokenRefreshEvent;
use App\Front\Publisher\Service\PublisherToken\PublisherTokenService;
use Illuminate\Contracts\Queue\ShouldQueue;

class PublisherTokenRefreshListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(private PublisherTokenService $tokenService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PublisherTokenRefreshEvent $event): void
    {
        $this->tokenService->revoke();
        $this->tokenService->create();
    }

    public function shouldQueue(PublisherTokenRefreshEvent $event): bool
    {
        return $event->isShouldQueue;
    }
}
