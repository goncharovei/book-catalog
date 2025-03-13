<?php

namespace App\Front\Publisher\Providers;

use App\Front\Publisher\Listeners\PublisherRegisteredListener;
use App\Front\Publisher\Service\PublisherToken\PublisherTokenService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
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
        $this->events();
        $this->authUrls();
    }

    private function events(): void
    {
        Event::listen(
            events: [Registered::class],
            listener: PublisherRegisteredListener::class
        );
    }

    private function authUrls(): void
    {
        ResetPassword::createUrlUsing(function ($notifiable, $token) {
            return url(route('publisher.auth.password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));
        });

    }
}
