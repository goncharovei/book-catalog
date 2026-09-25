<?php

namespace App\Front\Publisher\Listeners;

use App\Common\Models\Publisher;
use App\Front\Publisher\Mail\PublisherRegisteredMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;

class PublisherRegisteredListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        if (!($event->user instanceof Publisher))
        {
            return;
        }

        Mail::to(config('app.admin_email'))->send(new PublisherRegisteredMail($event->user));
    }

}
