<?php

namespace App\Front\Publisher\Listeners;

use App\Common\Service\PublisherToken\PublisherTokenService;
use App\Front\Publisher\Events\PublisherTokenRefreshEvent;
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
        $this->tokenService->setPublisher($event->publisher)->refresh();
    }

    public function shouldQueue(PublisherTokenRefreshEvent $event): bool
    {
        return $event->isShouldQueue;
    }
}
