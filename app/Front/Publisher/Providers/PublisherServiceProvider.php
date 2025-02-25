<?php

namespace App\Front\Publisher\Providers;

use App\Front\Publisher\Events\PublisherTokenRefreshEvent;
use App\Front\Publisher\Listeners\PublisherTokenRefreshListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class PublisherServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            events: [Registered::class, PublisherTokenRefreshEvent::class],
            listener: PublisherTokenRefreshListener::class
        );
    }
}
