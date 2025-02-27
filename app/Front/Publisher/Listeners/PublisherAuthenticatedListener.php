<?php

namespace App\Front\Publisher\Listeners;

use App\Common\Models\Publisher;
use App\Front\Publisher\Service\PublisherToken\PublisherTokenCache;
use App\Front\Publisher\Service\PublisherToken\PublisherTokenService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Contracts\Queue\ShouldQueue;

class PublisherAuthenticatedListener implements ShouldQueue
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
    public function handle(Authenticated $event): void
    {
        if (!($event->user instanceof Publisher))
        {
            return;
        }

        $this->tokenService->setDependencies(
            $event->user,
            resolve(PublisherTokenCache::class, [
                'cache' => Cache::store(),
                'crypt' => Crypt::getFacadeRoot(),
                'publisherId' => $event->user->id
            ])
        );
    }

}
