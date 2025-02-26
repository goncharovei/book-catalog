<?php

namespace App\Front\Publisher\Providers;

use App\Front\Publisher\Events\PublisherTokenRefreshEvent;
use App\Front\Publisher\Listeners\PublisherAuthenticatedListener;
use App\Front\Publisher\Listeners\PublisherTokenRefreshListener;
use App\Front\Publisher\Service\PublisherToken\PublisherTokenService;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class PublisherServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->instance(PublisherTokenService::class, new PublisherTokenService());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            events: [PublisherTokenRefreshEvent::class],
            listener: PublisherTokenRefreshListener::class
        );

        Event::listen(
            events: [Authenticated::class],
            listener: PublisherAuthenticatedListener::class
        );
    }
}
