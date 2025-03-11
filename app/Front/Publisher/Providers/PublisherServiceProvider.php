<?php

namespace App\Front\Publisher\Providers;

use App\Front\Publisher\Events\PublisherTokenRefreshEvent;
use App\Front\Publisher\Listeners\PublisherAuthenticatedListener;
use App\Front\Publisher\Listeners\PublisherRegisteredListener;
use App\Front\Publisher\Listeners\PublisherTokenRefreshListener;
use App\Front\Publisher\Service\PublisherToken\PublisherTokenService;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\ResetPassword;
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

        Event::listen(
            events: [Registered::class],
            listener: PublisherRegisteredListener::class
        );

        ResetPassword::createUrlUsing(function ($notifiable, $token) {
            return url(route('publisher.auth.password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));
        });
    }
}
